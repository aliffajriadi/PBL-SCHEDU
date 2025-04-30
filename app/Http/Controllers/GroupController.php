<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\MemberOf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class GroupController extends Controller
{

    private static function generate_code()
    {
        $template = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $str_length = strlen($template) - 1;
        $new_code;

        do{
            $new_code = '';       
            for($i = 0; $i < 6; $i++){
                $new_code .= $template[random_int(0, $str_length)];
            }
        }
        while(Group::where('group_code', $new_code)->exists());

        return $new_code;
    }

    public function dashboard(Request $request, Group $group)
    {
        $role = session('role');
        $user = Auth::user();
        $user_data = [
            $user->name, $user->email
        ];
    
        return view('group.group-dashboard', [
            'role' => $role, 
            'user' => $user_data,
            'group' => $group
        ]);
    }

    public function index(Request $request)
    {
        $groups = Group::query()->with(['instance:uuid,folder_name']);

        try {
            if($request->query('keyword')){
                $keyword = '%' . $request->query('keyword') . '%';
                $groups = $groups->where('title', 'like', $keyword);
            }

            return response()->json([
                'status' => true,
                'datas' => $groups->get(),
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            // dd($request);
            
            $field = $request->validate([
                'name' => 'required|max:255',
                'pic' => 'image|mimes:jpg,jpeg,png|max:2048'
            ]);

            $user = Auth::user();

            $field['group_code'] = self::generate_code();
            $field['instance_uuid'] = $user->instance_uuid;
            
            $group_folder = $user->instance->folder_name . '/groups/' . $field['group_code'];

            Storage::disk('public')->makeDirectory($group_folder);
            
            $file_name = null;
            
            if($request->hasFile('pic')){
                $file = $request->file('pic');
                $file_name = time() . '.' . $file->getClientOriginalExtension();

                $path = $group_folder . '/' . $file_name;
    
                $file->storeAs($group_folder, $file_name, 'public');
            } 
            
            $field['pic'] = $file_name;

            $group = Group::create([
                'group_code' => $field['group_code'],
                'instance_uuid' => $field['instance_uuid'],
                'pic' => $field['pic'],
                'name' => $field['name'] 
            ]);
            
            MemberOf::create([
                'user_uuid' => $user->uuid,
                'group_id' => $group->id,
                'verified' => true
            ]);

            return redirect('/group');

            return response()->json([
                'status' => true,
                'message' => 'Group Made Successfully'
            ]);
            
        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'name' => $request->input('name')
            ]);
        }
    }

    public function update(Request $request, Group $group)
    {
        try {
           
            $field = $request->validate([
                'name' => 'required|max:255',
            ]);

            $group->update($field);
            $group->save();

            return response()->json([
                'status' => true,
                'message' => 'Group Updated Successfully'
            ]);
            
        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy(Group $group)
    {
        try {
            Storage::disk('public')->deleteDirectory($group->instance->folder_name . '/groups/' . $group->group_code);

            $group->delete();

            return response()->json([
                'status' => true,
                'message' => 'Note Deleted Successfully'
            ]);
            
        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}