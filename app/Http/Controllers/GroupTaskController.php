<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\GroupTask;
use App\Models\GroupTaskUnit;
use Illuminate\Support\Facades\Auth;

class GroupTaskController extends Controller
{
    public function index()
    {
        try{
            $unit = GroupTaskUnit::query()->with('task')->get();
            
            return response()->json([
                'status' => true,
                'datas' => $unit
            ]);

        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function dashboard(Group $group)
    {
        $role = session('role');
        $user = Auth::user();
        $user_data = [
            $user->name, $user->email
        ];
    
        return view('group.group-task', [
            'role' => $role, 
            'user' => $user_data,
            'unit_datas' => GroupTaskUnit::where('group_id', $group->id)->get()
        ]);
    }

    public function show(Group $group, GroupTask $api)
    {
        try {
            return response()->json([
                'status' => true, 
                'data' => $api
            ]);
            
        }catch(\Exception $e){
            return response()->json([
                'status' => false, 
                'message' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request, Group $group)
    {
        try{


            $field = $request->validate([
                'title' => 'required|max:255',
                'unit_id' => 'required', 
                'content' => 'required',
                'deadline' => 'required|date'
            ]);

            $field['group_id'] = $group->id;
            $field['created_by'] = Auth::user()->uuid;

            GroupTask::create($field);

            return response()->json([
                'status' => true, 
                'message' => 'Task Added Successfully'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false, 
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, String $group, GroupTask $api)
    {
        try{
            $field = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'deadline' => 'required|date'
            ]);

            $api->update($field);

            return response()->json([
                'status' => true, 
                'message' => 'Task Updates Successfully'
            ]);
            
        }catch(\Exception $e) {
            return response()->json([
                'status' => false, 
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy(String $group, GroupTask $api)
    {
        try{
            $api->delete();
            
            return response()->json([
                'status' => true, 
                'message' => 'Task Successfully Deleted'
            ]);
        }catch(\Exception $e) {
            return response()->json([
                'status' => false, 
                'message' => $e->getMessage()
            ]);
        }
    }
}
