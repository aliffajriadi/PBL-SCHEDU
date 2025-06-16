<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function login_page()
    {
        if(Auth::user() !== null) redirect('/dashboard');
        return view('login');
    }

    public function login(Request $request)
    {
        try {
            if(Auth::user() !== null) redirect('/dashboard');

            $credentials = $request->validate([
                'email' => 'required',
                'password' => 'required'
            ]);

            if (!Auth::attempt($credentials)) {
                return redirect('/login');
            }

            $user = Auth::user();
            session([
                'role' => $user->is_teacher ? 'teacher' : 'student',
                'notification_count' => $user->notification()->where('is_read', false)->count()
            ]);

            // return redirect('/dashboard');
            $request->session()->regenerate();



            return redirect('/dashboard');

            // return response()->json([
            //     'status' => true,
            //     'message' => 'Login Successfully',
            //     'data' => Auth::user(),
            //     'role' => session('role')
            // ]);
        } catch (\Exception $e) {
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

            return redirect('/login');
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
