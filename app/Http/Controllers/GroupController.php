<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\GroupNote;
use App\Models\GroupSchedule;
use App\Models\GroupTask;
use App\Models\MemberOf;
use App\Models\GroupTaskUnit;
use App\Models\InstanceNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class GroupController extends Controller
{

    private static function generate_code()
    {
        $template = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $str_length = strlen($template) - 1;
        $new_code = '';

        do{
            $new_code = '';       
            for($i = 0; $i < 6; $i++){
                $new_code .= $template[random_int(0, $str_length)];
            }
        }
        while(Group::where('group_code', $new_code)->exists());

        return $new_code;
    }

    public function dashboard(Group $group)
    {   
        Gate::allows('is_member', $group);

        $id = $group->id;

        $role = session('role');
        $user = Auth::user();
        $user_data = [
            $user->name, $user->email
        ];
    
        $note = GroupNote::where('group_id', $id);
        $schedule = GroupSchedule::where('group_id', $id);
        
        $task = GroupTask::where('group_id', $id);
        
        if($role === 'student'){
            $task->whereDoesntHave('submission', function ($query) use ($user) {
                $query->where('user_uuid', $user->uuid);
            });
        }

        $members = MemberOf::with(['user:uuid,name'])->where('group_id', $id)->limit(5)->get();

        return view('group.group-dashboard', [
            'role' => $role, 
            'user' => $user_data,
            'group' => $group,
            'members' => $members,
            'note_total' => $note->count(), 
            'task_total' => $task->count(),
            'schedule_total' => $schedule->count(),
            'notes' => $note->orderBy('updated_at', 'DESC')->limit(3)->get(),
            'tasks' => $task->orderBy('updated_at', 'DESC')->limit(3)->get(),
            'schedules' => $schedule->get(),
            'userData' => $user
        ]);
    }

    public function group_list()
    {
        $role = session('role');
        $user = Auth::user();
        $user_data = [
            $user->name, $user->email
        ];
    
        return view('group.group-list', [
            'role' => $role,
            'user' => $user_data,
            'folder_name' => Auth::user()->instance->folder_name,
            'userData' => $user
        ]);
    }

    public function index(Request $request)
    {
        $groups_ids = MemberOf::with('group')->where('user_uuid', Auth::user()->uuid)->where('verified', true)->pluck('group_id');

        $groups = Group::with('user:uuid,name')->withCount(['note', 'task', 'schedule', 'member'])->whereIn('id', $groups_ids);

        try {
            if($request->query('keyword')){
                $keyword = $request->query('keyword');
                $groups = $groups->where('name', 'like', "%$keyword%")->orderByRaw(
                    "CASE 
                            WHEN name LIKE ? THEN 1
                            WHEN name LIKE ? THEN 2
                            ELSE 3
                        END",
                        ["$keyword%", "%$keyword%"]);
            }

            return response()->json([
                'status' => true,
                'datas' => $groups->paginate(6),
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

            Gate::allows('create');
            
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

                $file->storeAs($group_folder, $file_name, 'public');
            } 
            
            $field['pic'] = $file_name;

            $group = Group::create([
                'group_code' => $field['group_code'],
                'instance_uuid' => $field['instance_uuid'],
                'pic' => $field['pic'],
                'name' => $field['name'],
                'created_by' => Auth::user()->uuid
            ]);

            InstanceNotificationController::store(
                'Grup has ready', 
                "Group has reade created for {$field['name']} created by {$user->name}", 
                $user->instance_uuid
            );
            
            MemberOf::create([
                'user_uuid' => $user->uuid,
                'group_id' => $group->id,
                'verified' => true
            ]);

            return redirect('/group')->with('success', 'Success Add In Group.');
            
        }catch(\Exception $e) {
            return redirect('/group')->with('error', $e->getMessage());
            
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
     
            // Gate::allows('is_member', [$group]);
            // Gate::allows('modify_permission', [$group]);

            $request->validate([
                'name' => 'required|max:255',
                'pic' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // dd($request->hasFile('pic'));

            if($request->hasFile('pic')){
                $folder_name = Auth::user()->instance->folder_name;
                $group_code = $group->group_code;
                $file = $request->file('pic');
                $file_name = time() . '.' . $file->getClientOriginalExtension();

                if(Storage::disk('public')->exists("$folder_name/groups/$group_code/{$group->pic}")){
                    Storage::disk('public')->delete("$folder_name/groups/$group_code/{$group->pic}");
                }

                $group->pic = $file_name;

                $file->storeAs("$folder_name/groups/$group_code", $file_name, 'public');
            }


            $group->name = $request->input('name');
            $group->save();

            return redirect("/group/{$group->group_code}/settings")->with('success', 'Success Update Data Group.');
            
        }catch(\Exception $e) {
            return redirect("/group/{$group->group_code}/settings")->with('error', $e->getMessage());
        }
    }

    public function destroy(Request $request, Group $group)
    {
        try {

            $user = Auth::user();

            $request->validate([
                'password' => 'required|string'
            ]);

            if(!Hash::check($request->input('password'), $user->password)){
                throw new \Exception('Wrong password');
            }

            Gate::allows('is_member', [$group]);
            Gate::allows('modify_permission', [$group]);

            Storage::disk('public')->deleteDirectory($group->instance->folder_name . '/groups/' . $group->group_code);

            $group->delete();

            InstanceNotificationController::store(
                'Group Has Deleted', 
                "A Group Has Ben Delete {$group->name} by {$user->name}", 
                $user->instance_uuid
            );

            return redirect('/group')->with('success', 'Group Deleted Successfully');

            
        }catch(\Exception $e) {
            return redirect()->back()->with('error', 'There is something wrong when deleting group: ' . $e->getMessage());
        }
    }
}