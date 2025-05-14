<?php

namespace App\Http\Controllers;

use App\Models\GroupSchedule;
use App\Models\Group;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class GroupScheduleController extends Controller
{
    public function index(Request $request, Group $group)
    {
        try {

            $schedules = GroupSchedule::where('group_id', $group->id)->orderByDesc('created_at');

            $keyword = $request->query('keyword') ?? false;

            if($keyword) {
                $schedules->where('title', 'LIKE', "%$keyword%")->orderByRaw(
                    "CASE 
                            WHEN title LIKE ? THEN 1
                            WHEN title LIKE ? THEN 2
                            ELSE 3
                        END", ["$keyword%", "%$keyword%"]
                );
            }

            return response()->json([
                'status' => true,
                'datas' => GroupSchedule::all()
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
        Gate::allows('create');
        
        try {
            $field = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'start_datetime' => 'required',
                'end_datetime' => 'required'
            ]);

            $field['group_id'] = $group->id;

            GroupSchedule::create($field);
            
            return response()->json([
                'status' => true,
                'message' => 'New Schedule Successfully Added'
            ]);

        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, Group $group, GroupSchedule $api)
    {
        try{
            Gate::allows('permission', [$api]);

            $field = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'start_datetime' => 'required',
                'end_datetime' => 'required'
            ]);

            $api->update($field);
            $api->save();
            
            return response()->json([
                'status' => true,
                'message'=> 'Group Schedule Updated Successfully'
            ]);

        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message'=> $e->getMessage()
            ]);
        }
    }

    public function destroy(Request $request, Group $group, GroupSchedule $api)
    {
        try {
            Gate::allows('permission', [$api]);

            $api->delete();

            return response()->json([
                'status' => true,
                'message'=> 'Schedule Deleted Successfully'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message'=> $e->getMessage()
            ]);
        }


    }
}
