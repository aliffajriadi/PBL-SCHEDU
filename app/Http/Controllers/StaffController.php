<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class StaffController extends Controller
{

    private static function generate_code()
    {
        $template = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $str_length = strlen($template) - 1;
        $new_code;

        do{
            $new_code = '';       
            for($i = 0; $i < 6; $i++){
                $new_code .= $template[random_int(0, $str_length)];
            }
        }
        while(Staff::where('folder_name', $new_code)->exists());

        return $new_code;
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);

            if(!Auth::guard('staff')->attempt($credentials)){
                return response()->json([
                    'status' => false,
                    'message' => 'Wrong Username or Password'
                ]);
            }

            return redirect('/staff/dashboard');

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

    public function index(Request $request)
    {
        try {
            $staffs = Staff::query();

            if($request->query('keyword')){
                $keyword = '%' . $request->query('keyword') . '%';
                $staffs = $notes->where('name', 'like', $keyword);
            }

            return response()->json([
                'status' => true,
                'datas' => $staffs->get()
            ]);

        }catch(\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $field = $request->validate([
                'username' => 'required|max:255',
                'instance_name' => 'required|max:255',
                'address' => 'required|max:255',
                'phone_no' => 'required|max:255'
            ]);

            $field['password'] = Hash::make('password');
            $folder_name = self::generate_code();
            $field['folder_name'] = $folder_name;

            Storage::disk('public')->makeDirectory($folder_name);
            Storage::disk('public')->makeDirectory($folder_name . '/groups');
            Storage::disk('public')->makeDirectory($folder_name . '/pic');

            Staff::create($field);

            return response()->json([
                'status' => true,
                'message' => 'New Instance Addedd Successfully'
            ]);

        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, Staff $staff)
    {
        try {
            $field = $request->validate([
                'instance_name' => 'required|max:255',
                'address' => 'required|max:255',
                'phone_no' => 'required|max:255',
                'address' => 'required|max:255'
            ]);
    
            $staff->update($field);
    
            $staff->save();
    
            return response()->json([
                'status' => true,
                'message' => 'Instance Updated Successfully'
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function change_password(Request $request, Staff $staff)
    {
        try {
            $request->validate([
                'old_password' => 'required', 
                'password' => 'required|confirmed|max:255'
            ]);
    
            if(!Hash::check($request->input('old_password'), Auth::guard('staff')->user()->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Wrong Old Password'
                ]);
            }

            $staff->password = $request->input('password');
            $staff->save();

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

    public function destroy(Staff $staff)
    {
        try {
            Storage::disk('public')->deleteDirectory($staff->folder_name);
            $staff->delete();

            return response()->json([
                'status' => true,
                'message' => 'Staff Deleted Successfully'
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }   
    }
}
