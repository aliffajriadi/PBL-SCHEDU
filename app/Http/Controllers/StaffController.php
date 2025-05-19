<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Notification;
use App\Models\NotificationStatus;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class StaffController extends Controller
{
    public function view_login()
    {
        return view('staff.login');
    }
    public function view_account(Request $request)
    {
        $users = Auth::guard('staff')->user();

        // Ambil nilai search dan role dari URL
        $search = $request->input('search');
        $role = $request->input('role');

        // Query dasar
        $query = User::where('instance_uuid', $users->uuid);

        // Filter jika ada input search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        // Filter jika ada input role
        if ($role) {
            if ($role === 'teacher') {
                $query->where('is_teacher', 1);
            } elseif ($role === 'student') {
                $query->where('is_teacher', 0);
            }
        }

        $usersInInstance = $query->latest()->paginate(10);
        return view('staff.account', compact('users', 'usersInInstance', 'search'));
    }

    public function dashboard()
    {
        try {
            $user = Auth::guard('staff')->user();
            $dataCount = [
                'student' => User::where('is_teacher', 0,)->where('instance_uuid', $user->uuid)->count(),
                'teacher' => User::where('is_teacher', 1,)->where('instance_uuid', $user->uuid)->count(),
                'group' => Group::where('instance_uuid', $user->uuid)->count(),
            ];
            $notifications = NotificationStatus::with('notification')
                ->where('user_uuid', $user->uuid)
                ->latest()
                ->limit(4)
                ->get();
            $groups = Group::with('user')
                ->where('instance_uuid', $user->uuid)
                ->latest()
                ->limit(5)
                ->select('id', 'created_at', 'name')
                ->get();
            return view('staff.dashboard', compact('user', 'dataCount', 'notifications', 'groups'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error Get Data');
        }
    }

    private static function generate_code()
    {
        $template = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $str_length = strlen($template) - 1;
        $new_code = '';

        do {
            $new_code = '';
            for ($i = 0; $i < 6; $i++) {
                $new_code .= $template[random_int(0, $str_length)];
            }
        } while (Staff::where('folder_name', $new_code)->exists());

        return $new_code;
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string'
            ]);
            if (!Auth::guard('staff')->attempt($credentials)) {
                return redirect()->back()->with('error', 'Wrong email or password');
            };

            return redirect('/staff/dashboard')->with('success', 'Login Success');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Login failed: ' . $e->getMessage());
        }
    }


    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/staff/login')->with('success', 'Logout Success');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Logout failed: ' . $e->getMessage());
        }
    }

    public function index(Request $request)
    {
        try {
            $staffs = Staff::query();

            if ($request->query('keyword')) {
                $keyword = '%' . $request->query('keyword') . '%';
                $staffs = $notes->where('name', 'like', $keyword);
            }

            return response()->json([
                'status' => true,
                'datas' => $staffs->get()
            ]);
        } catch (\Exception $e) {
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
                'email' => 'required|email|max:255',
                'instance_name' => 'required|max:255',
                'address' => 'required|max:255',
                'phone_no' => 'required|max:255',
                'password' => 'required|min:8'  // Validasi password

            ]);
            $field['password'] = Hash::make($field['password']);

            $folder_name = self::generate_code();
            $field['folder_name'] = $folder_name;

            Storage::disk('public')->makeDirectory($folder_name);
            Storage::disk('public')->makeDirectory($folder_name . '/groups');
            Storage::disk('public')->makeDirectory($folder_name . '/pic');

            Staff::create($field);

            return redirect()->back()->with('success', 'Berhasil Menambahkan Staff');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal Menambahkan Staff');
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
        } catch (\Exception $e) {
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

            if (!Hash::check($request->input('old_password'), Auth::guard('staff')->user()->password)) {
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
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update_password_user(Request $request)
    {
        try {
            /** @var \App\Models\Staff $user */
            $request->validate([
                'current_password_instance' => 'required',
                'new_password' => 'required|min:6|confirmed', // otomatis cocokkan dengan new_password_confirmation
            ]);
            $userInstance = User::where('uuid', $request['uuidUser'])->first();

            $user = Auth::guard('staff')->user();
            if (!Hash::check($request['current_password_instance'], $user->password)) {
                return redirect()->back()->with('error', 'Current Password Instance not match');
            }
            $password_new = Hash::make($request['new_password']);;
            $userInstance->password = $password_new;
            $userInstance->save();
            return back()->with('success', 'Password updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed change password' . $th);
        }
    }

    public function update_user($uuid, Request $request)
    {
        try {
            $userInstance = User::where('uuid', $uuid)->firstOrFail();

            $request->validate([
                'email' => 'required|email|unique:users,email,' . $userInstance->uuid . ',uuid',
                'name' => 'required',
                'birth_date' => 'required|date',
                'is_teacher' => 'required|boolean',
                'gender' => 'required|in:F,M',
            ]);

            $userInstance->update($request->only([
                'email',
                'name',
                'birth_date',
                'is_teacher',
                'gender'
            ]));

            return back()->with('success', 'User updated successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed Update Account: ' . $th->getMessage());
        }
    }


    public function destroy(Staff $staff)
    {
        try {
            // Hapus folder jika ada
            if (!empty($staff->folder_name) && Storage::disk('public')->exists($staff->folder_name)) {
                Storage::disk('public')->deleteDirectory($staff->folder_name);
            }

            // Tetap hapus data staff, terlepas dari folder ada atau tidak
            $staff->delete();

            return redirect()->back()->with('success', 'Delete Success');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Delete Failed');
        }
    }
}
