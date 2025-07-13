<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalNote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class PersonalNoteController extends Controller
{
    public function __construct()
    {
        NotificationController::refresh_notification();
    }

    public function home()
    {
        $user = Auth::user();
        $user_data = [$user->name, $user->email];
        

        return view('teachStudent.notes-detail', [
            'user' => $user_data,
            'userData' => $user
            
        ]);
    
    }

    public function index(Request $request)
    {
        $notes = PersonalNote::query()->where('user_uuid', Auth::user()->uuid);

        try {
            $keyword = $request->query('keyword');

            if($request->query('keyword')){

                $notes = $notes->where('title', 'like', "%$keyword%")->orderByRaw(
                    "CASE
                            WHEN title LIKE ? THEN 1
                            WHEN title LIKE ? THEN 2
                            ELSE 3
                        END",
                        ["$keyword%", "%$keyword%"]
                );
            }
            
            return response()->json([
                'status' => true,
                'datas' => $notes->paginate(5)
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
            DB::beginTransaction();
           
            $field = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required'
            ]);

            $field['user_uuid'] = Auth::user()->uuid;

            PersonalNote::create($field);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Note Added Successfully'
            ]);
            
        }catch(\Exception $e) {

            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, PersonalNote $api)
    {
        DB::beginTransaction();
        try {

            Gate::allows('own', [$api]);

            $field = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required'
            ]);

            $api->update($field);
            $api->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Note Updated Successfully'
            ]);
            
        }catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy(PersonalNote $api)
    {
        DB::beginTransaction();

        try {
            Gate::allows('own', [$api]);

            $api->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Note Deleted Successfully'
            ]);
            
        }catch(\Exception $e) {
            
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
