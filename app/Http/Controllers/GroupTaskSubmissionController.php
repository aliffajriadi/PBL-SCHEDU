<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupTaskSubmission;
use App\Models\TaskFileSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GroupTaskSubmissionController extends Controller
{
    public function store(Request $request, String $group, int $group_task)
    {
        try{
            $field = $request->validate([
                'description',
                'file_submissions' => 'array',
                'file_submissions.*' => 'file'
            ]);

            // dd($request->all());

            $field['user_uuid'] = Auth::user()->uuid;
            $field['group_task_id'] = $group_task;
            
            $submission = GroupTaskSubmission::create($field);

            $folder_name = Auth::user()->instance->folder_name . '/groups/' . $group;

            if($request->hasFile('file_submissions')){
                $files = $request->file('file_submissions');

                $fileable_type = GroupTaskSubmission::class;

                foreach($files as $file){
                    if($file->isValid()){
                        $task_file = TaskFileSubmission::create([
                            'original_name' => $file->getClientOriginalName(),
                            'submission_id' => $group_task,
                            'fileable_type' => $fileable_type,
                            'fileable_id' => $submission->id
                        ]);

                        $task_file->stored_name = $task_file->id . '.' . $file->getClientOriginalExtension();
                        $task_file->save();

                        $file->storeAs($folder_name , $task_file->stored_name, 'public');
                    }
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Submission Already Submitted',
                'submission' => $submission,
                'field' => $field 
            ]);

        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
        
    }
}
