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
        if(Auth::check()) return redirect('/dashboard');
        return view('login');
    }

    public function login(Request $request)
    {
        try {
        // if(Auth::user() !== null) redirect('/dashboard');

            $credentials = $request->validate([
                'email' => 'required',
                'password' => 'required'
            ]);

            if (!Auth::attempt($credentials)) {
                throw new \Exception('Username atau Password yang anda berikan salah.'); 
            }

            $user = Auth::user();
            session([
                'role' => $user->is_teacher ? 'teacher' : 'student',
                'notification_count' => $user->notification()->where('is_read', false)->count()
            ]);

            // return redirect('/dashboard');
            $request->session()->regenerate();

            if(session('url.intended')){
                return redirect()->intended('/dashboard');
            }

            return redirect('/dashboard')->with('success', 'Berhasil login');

            // return response()->json([
            //     'status' => true,
            //     'message' => 'Login Successfully',
            //     'data' => Auth::user(),
            //     'role' => session('role')
            // ]);
        } catch (\Exception $e) {

            return redirect('/login')->with('error', $e->getMessage());

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
