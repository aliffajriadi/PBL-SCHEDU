<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalNote;

use Illuminate\Support\Facades\Auth;

class PersonalNoteController extends Controller
{
    public function home()
    {
        return view('teachStudent.notes');
    }

    public function index(Request $request)
    {
        $notes = PersonalNote::query();
        // where('uuid', Auth::user()->uuid);

        try {
            if($request->query('keyword')){
                $keyword = '%' . $request->query('keyword') . '%';

                $notes = $notes->where('title', 'like', $keyword);
            }
            
            return response()->json([
                'status' => true,
                'datas' => $notes->get()
            ]);
            
        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function show(PersonalNote $api)
    {
        return response()->json([
            'data' => $api
        ]);
    }

    public function store(Request $request)
    {
        try {
           
            $field = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required'
            ]);

            $field['user_uuid'] = Auth::user()->uuid;

            

            PersonalNote::create($field);

            return response()->json([
                'status' => true,
                'message' => 'Note Added Successfully'
            ]);
            
        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, PersonalNote $api)
    {
        try {
           
            $field = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required'
            ]);

            $api->update($field);
            $api->save();

            return response()->json([
                'status' => true,
                'message' => 'Note Updated Successfully'
            ]);
            
        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy(PersonalNote $api)
    {
        try {
            $api->delete();

            return response()->json([
                'status' => true,
                'message' => 'Note Deleted Successfully'
            ]);
            
        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
