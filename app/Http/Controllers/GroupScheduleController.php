<?php

namespace App\Http\Controllers;

use App\Models\GroupSchedule;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupScheduleController extends Controller
{
    public function index(Request $request, Group $group)
    {
        try {
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
