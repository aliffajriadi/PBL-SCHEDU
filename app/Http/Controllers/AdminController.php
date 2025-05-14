<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);

            if(!Auth::guard('admin')->attempt($credentials)){
                // return response()->json([
                //     'status' => false,
                //     'message' => 'Wrong Username or Password'
                // ]);
            
                return redirect('/adm_login');

            }

            // return response()->json([
            //     'status' => true,
            //     'message' => 'Login Successfully'
            // ]);
            
            return redirect('/admin/dashboard');

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

            return redirect('/adm_login');

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

    public function index()
    {
        return view('admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        try {
            $request->validate([
                'username' => 'required|max:255',
            ]);

            $admin->username = $request->input('username');
            $admin->save();

            return response()->json([
                'status' => true,
                'message' => 'Username Updated Successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage
            ]);
        }
    }

    public function change_password(Request $request, Admin $admin)
    {
        try {
            $request->validate([
                'old_password' => 'required|max:255',
                'password' => 'required|confirmed|max:255',
            ]);
    
            if(!Hash::check($request->input('old_password'), Auth::guard('admin')->user()->password)){
                return response()->json([
                    'status' => false,
                    'message' => 'Wrong Old Password'
                ]);
            }
    
            $admin->password = Hash::make($request->input('password'));
            $admin->save();
    
            return response()->json([
                'status' => true,
                'message' => 'Password Changed Successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage
            ]);
        }
    }


    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
