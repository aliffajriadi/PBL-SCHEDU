<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupTaskSubmission;
use App\Models\TaskFileSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GroupTaskSubmissionController extends Controller
{
    public function store(Request $request, String $group, int $group_task)
    {
        try{
            $field = $request->validate([
                'description' => 'string',
                'files' => 'array',
                'files.*' => 'file'
            ]);

            // dd($request->all());

            $submission_template = [];
            $submission_template['user_uuid'] = Auth::user()->uuid;
            $submission_template['group_task_id'] = $group_task;
            $submission_template['description'] = $field['description'];
            $submission = GroupTaskSubmission::create($submission_template);

            $folder_name = Auth::user()->instance->folder_name . '/groups/' . $group;

            if($request->hasFile('files')){
                $files = $request->file('files');

                $fileable_type = GroupTaskSubmission::class;

                foreach($files as $file){
                    if($file->isValid()){
                        $task_file = TaskFileSubmission::create([
                            'original_name' => $file->getClientOriginalName(),
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
                'request' => $request->all(),
                'message' => $e->getMessage()
            ]);
        }
        
    }
    
    public function update(Request $request, String $group, GroupTaskSubmission $submission)
    {
        try{
            $field = $request->validate([
                'description' => 'string',
                'score' => 'int',
                'files' => 'array',
                'files.*' => 'file' 
            ]);

            // return $request->all();

            if($request->filled('description')){
                $submission->description = $field['description'];
            }elseif($request->filled('score')){
                $submission->score = $field['score'];
            }

            $submission->save();


            if($request->hasFile('files')){
                $files = $request->file('files');
                $folder_name = Auth::user()->instance->folder_name . '/groups/' . $group;

                $fileable_type = GroupTaskSubmission::class;

                foreach($files as $file){
                    if($file->isValid()){
                        $task_file = TaskFileSubmission::create([
                            'original_name' => $file->getClientOriginalName(),
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
                'message' => 'Submission updated successfully'
            ]);

        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
        
    }

    public function destroy(String $group, GroupTaskSubmission $submission)
    {
        try{        
            $submission_files = $submission->file()->get();
            $folder_name = Auth::user()->instance->folder_name;

            foreach($submission_files as $file){
                Storage::disk('public')->delete("{$folder_name}/groups/{$group}/{$file->stored_name}");
                $file->delete();
            }

            $submission->delete();

            return response()->json([
                'status' => true,
                'message' => 'Submission deleted successfully'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete_file(String $group, TaskFileSubmission $taskFileSubmission)
    {
        try {
            $folder_name = Auth::user()->instance->folder_name;
         
            Storage::disk('public')->delete("{$folder_name}/groups/{$group}/{$taskFileSubmission->stored_name}");
            $taskFileSubmission->delete();

            return response()->json([
                'status'=> true, 
                'message' => 'File deleted successfully'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function download_file(String $group, String $stored_name)
    {
        $folder_name = Auth::user()->instance->folder_name;

        $path  = Storage::disk('public')->path("/{$folder_name}/groups/{$group}/$stored_name");
        return response()->download($path);
    }
}
