<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Group;
use App\Models\GroupNote;

use Illuminate\Support\Facades\Auth;

class GroupNoteController extends Controller
{
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
                'datas' => $notes->get()
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
        try {
            $field = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'file'
            ]);

            $field['created_by'] = Auth::user()->uuid;

            $file_name = null;

            if($request->hasFile('file'))
            {
                $file = $request->file('file');
                
                $folder_path = $group->instance->folder_name . '/groups/' . $group->group_code;
                $file_name = time() . '.' . $file->getClientOriginalExtension();

                Storage::storeAs($folder_path, $file_name, 'public');            
            }

            $field['file'] = $file_name;
            $field['group_id'] = $group->id;
            GroupNote::create($field);

            $notification = NotificationController::store(
                'Catatan Group Baru', 'Catatan baru sudah dibuat disuatu grup', null, $group->id
            );

            return response()->json([
                'status' => 200,
                'message' => 'New Note Added Successfully',
                'notif' => $notification
            ]);

        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'request' => $request->all()

            ]);
        }
    }

    public function update(Request $request, Group $group, GroupNote $api)
    {
        try {
            $field = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'file' => 'nullable|file'
            ]);

            if($api->pic !== null){
                Storage::disk('public')->delete(Auth::user()->instance->folder_name . '/groups/' . $group->group_code .'/'. $api->pic);
            } 
            
            $file_name = null;

            if($request->hasFile('file'))
            {
                $file = $request->file('file');
                
                $folder_path = $group->instance->folder_name . '/groups/' . $group->group_code;
                $file_name = time() . '.' . $file->getClientOriginalExtension();

                Storage::storeAs($folder_path, $file_name, 'public');            
            }

            $field['file'] = $file_name;

            $api->update($field);
            // $note->save();

            return response()->json([
                'status' => true,
                'message' => 'Note Updated Successfully',
                'request' => $field['title']

            ]);

        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'request' => $field['title']


            ]);
        }
    }

    public function destroy(Group $group, GroupNote $api)
    {
        try {
            if($api->pic !== null){
                Storage::disk('public')->delete(Auth::user()->instance->folder_name . '/groups/' . $group->group_code .'/'. $api->pic);
            } 

            $temp = $api;

            $api->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Note Deleted Successfully',
                'api' => $temp
            ]);

        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()

            ]);
        }
    }
}
