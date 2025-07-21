<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ParticipantController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if(!Auth::attempt($credentials)){
                return response()->json([
                    'status' => false,
                    'message' => 'Wrong Username or Password'
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Login Successfully'
            ]);
            
        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function logout(Request $request) 
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'status' => true,
                'message' => 'Logout Successfully'
            ]);
            
        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $field = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email',
                'birth_date' => 'required',
                'is_teacher' => 'required',
                'gender' => 'required|max:1',
                'password' => 'required'
            ]);

            $field['password'] = Hash::make($field['password']);
            $field['instance_id'] = Auth::guard('user')->user()->id;

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'New User Addedd Successfully'
            ]);

        }catch(\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, User $user)
    {
        DB::beginTransaction();

        try {
            $field = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email',
                'birth_date' => 'required',
                'is_teacher' => 'required',
                'gender' => 'required|max:1',
            ]);
    
            $user->update($field);
            $user->save();
    
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Instance Updated Successfully'
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function change_password(Request $request, User $user)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'old_password' => 'required', 
                'password' => 'required|confirmed|max:255'
            ]);
    
            if(!Hash::check($request->input('old_password'), Auth::guard('user')->user()->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Wrong Old Password'
                ]);
            }

            $user->password = $request->input('password');
            $user->save();

            DB::commit();

            return redirect()->back()->with('success', 'Password updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Password Updated Successfully'
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            
            return redirect()->back()->with('error', 'Failed to update password');

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy(User $user)
    {
        DB::beginTransaction();

        try {
            $user->delete();
            
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'User Deleted Successfully'
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }   
    }

}
