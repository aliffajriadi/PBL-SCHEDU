<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;


class GroupController extends Controller
{

    private static function generate_code()
    {
        $template = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $str_length = strlen($template) - 1;
        $new_code;

        do{
            $new_code = '';       
            for($i = 0; $i < 6; $i++){
                $new_code .= $template[rand(0, $str_length)];
            }
        }
        while(Group::where('join_code')->exists());

        return $new_code;
    }

    public function store(Request $request)
    {
        try {
           
            $field = $request->validate([
                'name' => 'required|max:255',
                'pic' 
            ]);

            $field['join_code'] = self::generate_code();
            $field['instance_id'] = Auth::user()->instance_id;
            $field['pic'] =
            Group::create($field);

            return response()->json([
                'status' => true,
                'message' => 'Group Made Successfully'
            ]);
            
        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, Group $group)
    {
        try {
           
            $field = $request->validate([
                'name' => 'required|max:255',
            ]);

            $group->update($field);
            $group->save();

            return response()->json([
                'status' => true,
                'message' => 'Group Updated Successfully'
            ]);
            
        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy(Group $group)
    {
        try {
            $group->delete();

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