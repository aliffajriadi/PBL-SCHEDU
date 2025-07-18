<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Group;
use App\Models\GroupNote;
use App\Models\TaskFileSubmission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class GroupNoteController extends Controller
{
    public function __construct()
    {
        NotificationController::refresh_notification();
   
    }
    
    public function home(Request $request, Group $group)
    {
        Gate::allows('is_member', [$group]);

        $role = session('role');
        $user = Auth::user();
        $user_data = [
            $user->name, $user->email
        ];

        $latest_notes = GroupNote::where('group_id', $group->id)->orderByDesc('created_at')->limit(3)->get();

        return view('group.group-notes', [
            'role' => $role, 
            'user' => $user_data,
            'latest_notes' => $latest_notes,
            'userData' => $user
        ]);
    }

    public function index(Request $request, Group $group)
    {
        try {
            $notes = GroupNote::query()->where('group_id', $group->id)->orderByDesc('created_at');
            
            $keyword = $request->query('keyword');

            if($keyword){
                $keyword = '%' . $keyword . '%';
                $notes->where('title', 'like', $keyword); 
            }

            return response()->json([
                'datas' => $notes->paginate(5)
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        } 
    }

    public function show(Request $request, Group $group, GroupNote $api)
    {
        try {

            return response()->json([
                'data' => $api,
                'files' => $api->file
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

        DB::beginTransaction();

        try {
            $field = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'files' => 'array',
                'files.*' => 'file'
            ]);

            $field['created_by'] = Auth::user()->uuid;
            $field['group_id'] = $group->id;
            
            $note = GroupNote::create($field);

            $notification = NotificationController::store(
                'Notes Group Has Created', "New Notes Has Ben Created in $group->name.", GroupNote::class, $note->id, false, now()->setTimezone('Asia/Jakarta'), $group->id
            );

            if($request->hasFile('files')){
                $files = $request->file('files');

                $fileable_type = GroupNote::class;

                $folder_name = Auth::user()->instance->folder_name;

                foreach($files as $file){
                    if($file->isValid()){
                        $note_file = TaskFileSubmission::create([
                            'original_name' => $file->getClientOriginalName(),
                            'fileable_type' => $fileable_type,
                            'fileable_id' => $note->id
                        ]);

                        $note_file->stored_name = $note_file->id . '.' . $file->getClientOriginalExtension();
                        $note_file->save();

                        $file->storeAs( "{$folder_name}/groups/{$group->group_code}" , $note_file->stored_name, 'public');
                    }
                }
            }

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'New Note Added Successfully',
                'notif' => $notification
            ]);

        }catch(\Exception $e){
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request, Group $group, GroupNote $api)
    {
        DB::beginTransaction();
        try {
            // return ['request' => $request->file('files')];

            $field = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'files' => 'array',
                'files.*' => 'file'
            ]);

            $api->update($field);
            // $note->save();


            if($request->hasFile('files')){
                $files = $request->file('files');

                $fileable_type = GroupNote::class;

                $folder_name = Auth::user()->instance->folder_name;

                foreach($files as $file){
                    if($file->isValid()){
                        $task_file = TaskFileSubmission::create([
                            'original_name' => $file->getClientOriginalName(),
                            'fileable_type' => $fileable_type,
                            'fileable_id' => $api->id
                        ]);

                        $task_file->stored_name = $task_file->id . '.' . $file->getClientOriginalExtension();
                        $task_file->save();

                        $file->storeAs("{$folder_name}/groups/{$group->group_code}" , $task_file->stored_name, 'public');
                    }
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Note Updated Successfully',
                'request' => $field['title']

            ]);

        }catch(\Exception $e){

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                // 'request' => $field['title']
            ]);
        }
    }

    public function destroy(Group $group, GroupNote $api)
    {

        DB::beginTransaction();

        try {
            $api->notification->delete();

            if($api->pic !== null){
                Storage::disk('public')->delete(Auth::user()->instance->folder_name . '/groups/' . $group->group_code .'/'. $api->pic);
            } 

            $temp = $api;

            $api->delete();

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Note Deleted Successfully',
                'api' => $temp
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

        $path  = Storage::disk('public')->path("/$folder_name/groups/$group/$stored_name");
        // dd(Storage::exists($path), $path);
        return response()->download($path);
    }

    public function delete_file(String $group, TaskFileSubmission $taskFileSubmission)
    {
        DB::beginTransaction();

        try {
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

    public function upload_file(Request $request, string $group, GroupNote $note)
    {

        DB::beginTransaction();
        
        try{
            $request->validate([
                'file' => 'required|file' 
            ]);
    
            $folder_name = Auth::user()->instance->folder_name;
            $file = $request->file('file');
    
            $task_file = TaskFileSubmission::create([
                'original_name' => $file->getClientOriginalName(),
                'fileable_type' => GroupNote::class,
                'fileable_id' => $note->id
            ]);
    
            $task_file->stored_name = $task_file->id . '.' . $file->getClientOriginalExtension();
            $task_file->save();
    
            $file->storeAs("{$folder_name}/groups/{$group}" , $task_file->stored_name, 'public');

            DB::commit();

            return response()->json([
                'status' => true,
                'stored_name' =>$task_file->stored_name,
                'original_name' => $task_file->original_name,
                'id' => $task_file->id, 
                'message' => 'New File Added Successfully'
            ]);

        }catch(\Exception $e){
            
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
