Z<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalNote;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class PersonalNoteController extends Controller
{
    public function home()
    {
        $user = Auth::user();
        $user_data = [$user->name, $user->email];

        return view('teachStudent.notes', [
            'user' => $user_data
        ]);
    
    }

    public function index(Request $request)
    {
        $notes = PersonalNote::query();


        try {
            $keyword = $request->query('keyword');

            if($request->query('keyword')){

                $notes = $notes->where('title', 'like', "%$keyword%")->orderByRaw(
                    "CASE
                            WHEN title LIKE ? THEN 1
                            WHEN title LIKE ? THEN 3
                            ELSE 3
                        END;",
                        ["$keyword%", "%$keyword%"]
                );
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
        try {
            Gate::allows('own', [$api]);

            return response()->json([
                'status' => true,
                'data' => $api
            ]);
        }catch(\Exception $e){
            
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }


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

            Gate::allows('own', [$api]);

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
            Gate::allows('own', [$api]);

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
