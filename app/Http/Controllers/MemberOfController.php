<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\MemberOf;


class MemberOfController extends Controller
{
    // masuk ke grup

    public function join_group(Request $request)
    {
        try {

            if(!$group){
                return response()->json([
                    'status' => false,
                    'message' => 'Unknown Join Code'
                ]);   
            }

            MemberOf::create([
                'user_uuid' => Auth::user()->uuid,
                'group_id' => $group->id,
                'verified' => false
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Successfully Join The Group'
            ]);           

        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    // diverifikasi 

    public function added(Request $request)
    {
        try {
            $memberOf = MemberOf::where('id', $request->input('id'))->firstOrFail();

            $memberOf->verified = true;
            $memberOf->save(); 

            return response()->json([
                'status' => true,
                'message' => 'Added New User'
            ]);
        
        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        
        }
    }


    // tidak diverifikasi, dikeluarkan, mengeluarkan diri 

    public function leave_group(Request $request)
    {
        try {
            $memberOf = MemberOf::where('id', $request->input('id'))->firstOrFail();

            $memberOf->delete();
            
            return response()->json([
                'status' => true,
                'message' => 'Leave the Group'
            ]);

        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
