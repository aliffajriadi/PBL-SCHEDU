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
            $notes = GroupNote::query()->where('group_id', $group->id);
            
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
        // dd($group, $api);

        try {
            // $api = GroupNote::firstOrFail($request->query('id'));

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

            // dd($group, $request->all());

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

            return response()->json([
                'status' => 200,
                'message' => 'New Note Added Successfully'

            ]);

        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'request' => $request->all()

            ]);
        }
    }

    public function update(Request $request, Group $group, GroupNote $note)
    {
        try {
            $field = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'file'
            ]);

            if($note->pic !== null){
                Storage::disk('public')->delete(Auth::user()->instance->folder_name . '/groups/' . $group->group_code .'/'. $note->pic);
            } 
            
            $file_name = null;

            if($request->hasFile)
            {
                $file = $request->file('file');
                
                $folder_path = $group->instance->folder_name . '/groups/' . $group->group_code;
                $file_name = time() . '.' . $file->getClientOriginalExtension();

                Storage::storeAs($folder_path, $file_name, 'public');            
            }

            $field['file'] = $file_name;

            $group->update($field);

        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()

            ]);
        }
    }

    public function destroy(Group $group, GroupNote $note)
    {
        try {
            if($note->pic !== null){
                Storage::disk('public')->delete(Auth::user()->instance->folder_name . '/groups/' . $group->group_code .'/'. $note->pic);
            } 

            $note->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Note Deleted Successfully' 
            ]);

        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()

            ]);
        }
    }
}
