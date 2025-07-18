<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupTask;
use App\Models\GroupTaskSubmission;
use App\Models\MemberOf;
use App\Models\TaskFileSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GroupTaskSubmissionController extends Controller
{
    public function store(Request $request, Group $group, GroupTask $group_task)
    {
        DB::beginTransaction();

        try{

            $user = Auth::user();

            Gate::allows('create_submission', $group_task);

            if($user->is_teacher || !MemberOf::where('user_uuid', $user->uuid)->where('group_id', $group_task->group_id)->exists()){
                abort(403, 'Your\'e not allowed to submit on this task!');
            }

            $field = $request->validate([
                'description' => 'string',
                'files' => 'array',
                'files.*' => 'file'
            ]);

            // dd($request->all());

            $submission_template = [];
            $submission_template['user_uuid'] = Auth::user()->uuid;
            $submission_template['group_task_id'] = $group_task->id;
            $submission_template['description'] = $field['description'];
            $submission = GroupTaskSubmission::create($submission_template);

            $folder_name = Auth::user()->instance->folder_name . '/groups/' . $group->group_code;

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

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Submission Already Submitted',
                'submission' => $submission,
                'field' => $field 
            ]);

        }catch(\Exception $e){
            
            DB::rollBack();
            return response()->json([
                'status' => false,
                'request' => $request->all(),
                'message' => $e->getMessage()
            ]);
        }
        
    }
    
    public function update(Request $request, String $group, GroupTaskSubmission $submission)
    {
        DB::beginTransaction();

        try{
            Gate::allows('owning', [$submission]);
            
            $field = $request->validate([
                'description' => 'string',
                'score' => 'int',
                'files' => 'array',
                'files.*' => 'file' 
            ]);

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

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Submission updated successfully'
            ]);

        }catch(\Exception $e){
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
        
    }

    public function destroy(String $group, GroupTaskSubmission $submission)
    {
        DB::beginTransaction();

        try{        
            Gate::allows('owning', [$submission]);

            $submission_files = $submission->file()->get();
            $folder_name = Auth::user()->instance->folder_name;

            foreach($submission_files as $file){
                Storage::disk('public')->delete("{$folder_name}/groups/{$group}/{$file->stored_name}");
                $file->delete();
            }

            $submission->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Submission deleted successfully'
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete_file(String $group, TaskFileSubmission $taskFileSubmission)
    {
        DB::beginTransaction();

        try {
     
            $submission = $taskFileSubmission->task;

            Gate::allows('own_file', [$submission]);

            $folder_name = Auth::user()->instance->folder_name;
         
            Storage::disk('public')->delete("{$folder_name}/groups/{$group}/{$taskFileSubmission->stored_name}");
            $taskFileSubmission->delete();

            DB::commit();

            return response()->json([
                'status'=> true, 
                'message' => 'File deleted successfully'
            ]);
        }catch(\Exception $e){
            DB::rollBack();

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
