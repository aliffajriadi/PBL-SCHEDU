<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\MemberOf;
use Illuminate\Support\Facades\Auth;


class MemberOfController extends Controller
{
    // masuk ke grup

    public function join_group(Request $request)
    {
        try {
            $group = Group::where('group_code', $request->input('group_code'))->where('instance_uuid', Auth::user()->instance_uuid);

            if(!$group->exists()){
                return response()->json([
                    'status' => false,
                    'message' => 'This group not exists in your instance',
                    'code' => $request->input('group_code'),
                    'instance_uuid' => Auth::user()->instance_uuid
                ]);   
            }

            MemberOf::create([
                'user_uuid' => Auth::user()->uuid,
                'group_id' => $group->first()->id,
                'verified' => false
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Successfully Join The Group'
            ]);           

        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'group' => $group
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
