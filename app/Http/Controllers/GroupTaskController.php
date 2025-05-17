<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\GroupTask;
use App\Models\GroupTaskUnit;
use Illuminate\Support\Facades\Auth;

class GroupTaskController extends Controller
{
    public function index(Request $request, Group $group)
    {
        try{
            $keyword = $request->query('keyword');
            
            $unit = GroupTaskUnit::query()->with('task')->orderBy('created_at', 'ASC');
            
            if($keyword) {
                $unit->whereHas('task', function ($model) use ($keyword) {
                    $model->where('title', 'LIKE', "%$keyword%")->orderByRaw("
                        CASE 
                            WHEN title LIKE ? THEN 1
                            WHEN title LIKE ? THEN 2
                            ELSE 3
                        END", ["$keyword", "%$keyword%"]);
                });
            }

            return response()->json([
                'status' => true,
                'datas' => $unit->get()
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
            'unit_datas' => GroupTaskUnit::where('group_id', $group->id)->orderBy('created_at')->get()
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
