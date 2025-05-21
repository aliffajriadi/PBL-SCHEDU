<?php

namespace App\Http\Controllers;

use App\Models\GroupTaskSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupTaskSubmissionController extends Controller
{
    public function create(Request $request, int $group_task)
    {
        try{
            $field = $request->validate([
                'description'
            ]);

            $field['user_uuid'] = Auth::user()->uuid;
            $field['group_task_id'] = $group_task;
            
            $submission = GroupTaskSubmission::create($field);

            return response()->json([
                'status' => true,
                'message' => 'Submission Already Submitted',
                'submission' => $submission
            ]);

        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
        
    }
}
