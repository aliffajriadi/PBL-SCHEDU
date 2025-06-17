<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Group;
use App\Models\Instance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function view_login(){
        return view('admin.login');
    }
    public function index()
    {
        $user = Auth::guard('admin')->user();
        $getInstance = Instance::latest()->limit(10)->get();
        $dataCount = [
            'student' => User::where('is_teacher', 0)->count(),
            'teacher' => User::where('is_teacher', 1)->count(),
            'instantiate' => Instance::count(),
            'group' => Group::count(),
        ];
        return view('admin.dashboard', compact('user', 'getInstance', 'dataCount'));
    }
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);
            if (!Auth::guard('admin')->attempt($credentials)) {
                return redirect()->back()->with('error', 'Username and password does not match')->withInput();
            }
            return redirect('/admin/dashboard')->with('success', 'Login Success');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed To Login Action');
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/admin/login')->with('success', 'Logout Success');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed To Logout Action');
        }
    }


    public function instatiate()
    {
        try {
            $user = Auth::guard('admin')->user();
            $search = request('search');
            $institutions = Instance::latest()
                ->when($search, function ($query, $search) {
                    return $query->where('instance_name', 'like', "%{$search}%");
                })
                ->paginate(10);
            return view('admin.instatiate', compact('user', 'institutions'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Action Error');
        }
    }

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
                'message' => $e
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

            if (!Hash::check($request->input('old_password'), Auth::guard('admin')->user()->password)) {
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
                'message' => $e
            ]);
        }
    }


    public function profile()
    {
        $user = Auth::guard('admin')->user();
        return view('admin.profile', compact('user'));
    }
    public function edit_password(Admin $admin, Request $request)
    {
        try {
            /** @var \App\Models\Admin $user */

            $user = Auth::guard('admin')->user();
            $field = $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:8|confirmed',
            ]);
            if (Hash::check($field['current_password'], $user->password)) {
                $user->password = Hash::make($field['password']);
                $user->save();
                return redirect()->back()->with('success', 'Password Success Change');
            } else {
                return redirect()->back()->with('error', 'Current Password not match');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error, canot update password');
        }
    }

    public function edit_username(Request $request)
    {
        
        try {
            /** @var \App\Models\Admin $user */
            $user = Auth::guard('admin')->user();

            // Validasi input
            $field = $request->validate([
                'updateNewUsername' => 'required|string|max:255|unique:admins,username,' . $user->uuid . ',uuid',
                'password_confirmation_current' => 'required',
            ]);
            
            // Cek password
            if (Hash::check($field['password_confirmation_current'], $user->password)) {
                $user->username = $field['updateNewUsername'];
                $user->save();

                return redirect()->back()->with('success', 'Username successfully changed to "' . $field['updateNewUsername'] . '".');
            } else {
                return redirect()->back()->with('error', 'Current password is incorrect.');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'An error occurred while updating the username.');
        }
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
