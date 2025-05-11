<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserController extends Controller
{
    public function user_check(Request $request)
    {
        return response()->json([
            'participant' => Auth::user(),
            'staff' => Auth::guard('staff')->user(),
            'admin' => Auth::guard('admin')->user(),
        ]);
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required',
                'password' => 'required'
            ]);

            if(!Auth::attempt($credentials)){
                return redirect('/login');

                // return response()->json([
                //     'status' => false,
                //     'message' => 'Wrong Email or Password'
                // ]);
            }

            $user = Auth::user();
            session(['role' => $user->is_teacher ? 'teacher' : 'student']);
            // return redirect('/dashboard');
            $request->session()->regenerate();

            return redirect('/dashboard');

            return response()->json([
                'status' => true,
                'message' => 'Login Successfully',
                'data' => Auth::user(),
                'role' => session('role')
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




    /**
     * Display a listing of the resource.
     */
    public function home()
    {
        return view('teachStudent.dashboard');
    }

    public function profile()
    {
        return view('profile', [
            'user' => Auth::user()->instance
        ]);
    }

    public function index(Request $request)
    {
        $instance_uuid = Auth::guard('staff')->user()->uuid;

        $users = User::query()->where('instance_uuid', $instance_uuid);

        if($request->query('keyword')){
            $keyword = '%' . $request->query('keyword') . '%';
            $users = $users->where('name', 'like', 'keyword');
        }

        return response()->json([
            'status' => true,
            'data' => $users->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            // return response()->json([
            //     'data' => Auth::guard('staff')->user()
            // ]);

            $field = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email',
                'gender' => 'required|max:255',
                'birth_date' => 'required|date',
                'is_teacher' => 'required',
                'password' => 'required'
            ]);

            $field['instance_uuid'] = Auth::guard('staff')->user()->uuid;
            $field['password'] = Hash::make($field['password']);
            $field['is_teacher'] = $field['is_teacher'] === 'teacher' ? 1 : 0;

            // dd($field);

            User::create($field);

            return response()->json([
                'status' => true,
                'message' => 'New User Addedd Successfully'
            ]);

        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            $field = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email',
                'gender' => 'required|max:255',
                'birth_Date' => 'required|date',
                'is_teacher' => 'required|boolean',
            ]);
    
            $user->update($field);
    
            $user->save();
    
            return response()->json([
                'status' => true,
                'message' => 'User Updated Successfully'
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function change_password(Request $request, User $user)
    {
        try {
            $request->validate([
                'old_password' => 'required', 
                'password' => 'required|confirmed|max:255'
            ]);
    
            if(!Hash::check($request->input('old_password'), Auth::user()->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Wrong Old Password'
                ]);
            }

            $user->password = $request->input('password');
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Password Updated Successfully'
            ]);

        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            
            return response()->json([
                'status' => true,
                'message' => 'User Deleted Successfully'
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }   
    }
}
