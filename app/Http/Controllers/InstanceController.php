<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\Instance;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\NotificationStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;



class InstanceController extends Controller
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

    public function view_group()
    {

        $user = Auth::guard('staff')->user();

        $groupList = Group::with(['user'])
            ->where('instance_uuid', $user->uuid)
            ->latest()
            ->limit(5)
            ->select('id', 'created_at', 'group_code', 'name', 'created_by', 'instance_uuid')
            ->paginate(10);

        
        return view('staff.group', compact('user', 'groupList'));
    }
    public function view_profile()
    {
        $user = Auth::guard('staff')->user();
        return view('staff.profile', compact('user'));
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
            $groups = Group::with('user:uuid,name')
                ->where('instance_uuid', $user->uuid)
                ->latest()
                ->limit(5)
                ->select('id', 'created_at', 'name', 'created_by')
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
        } while (Instance::where('folder_name', $new_code)->exists());

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
        
            session(['role' => 'staff']);
            $request->session()->regenerate();

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

            Instance::create($field);

            return redirect()->back()->with('success', 'Berhasil Menambahkan Instance');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal Menambahkan Instance');
        }
    }

    public function update(Request $request)
    {
        try {
            /** @var \App\Models\Instance $staff */
            $staff = Auth::guard('staff')->user();

            $request->validate([
                'instance_name' => 'required',
                'email' => 'required|email|unique:staff,email,' . $staff->uuid . ',uuid',
                'phone' => 'required',
                'address' => 'required',
                'logo_instance' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $staff->instance_name = $request->instance_name;
            $staff->email = $request->email;
            $staff->phone_no = $request->phone;
            $staff->address = $request->address;

            if ($request->hasFile('logo_instance')) {
                if ($staff->logo_instance) {
                    Storage::disk('public')->delete($staff->logo_instance);
                }
                $file = $request->file('logo_instance');
                $fileName = time() . '_' . $file->getClientOriginalName();

                $path = $file->storeAs($staff->folder_name, $fileName, 'public');
                $staff->logo_instance = $path;
            }

            $staff->save();

            return redirect()->back()->with('success', 'Berhasil memperbarui data.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function admin_update(Request $request, Instance $instance)
    {
        try {

            $request->validate([
                'instance_name' => 'required',
                'email' => 'required|email|unique:instances,email,' . $instance->uuid . ',uuid',
                'phone_no' => 'required',
                'address' => 'required',
                'logo_instance' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $instance->instance_name = $request->instance_name;
            $instance->email = $request->email;
            $instance->phone_no = $request->phone_no;
            $instance->address = $request->address;

            if ($request->hasFile('logo_instance')) {
                if ($instance->logo_instance) {
                    Storage::disk('public')->delete($instance->logo_instance);
                }
                $file = $request->file('logo_instance');
                $fileName = time() . '_' . $file->getClientOriginalName();

                $path = $file->storeAs($instance->folder_name, $fileName, 'public');
                $instance->logo_instance = $path;
            }

            $instance->save();

            return redirect()->back()->with('success', 'Berhasil memperbarui data.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function update_password(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:6',
            ]);
            /** @var \App\Models\Instance $userLogin */
            $userLogin = Auth::guard('staff')->user();
            if (!Hash::check($request['current_password'], $userLogin->password)) {
                return redirect()->back()->with('error', 'Current Password Instance not match');
            }
            $passwordNew = Hash::make($request['new_password']);
            $userLogin->password = $passwordNew;
            $userLogin->save();
            return redirect()->back()->with('success', 'Success Change Password');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update_password_user(Request $request)
    {
        try {
            /** @var \App\Models\Instance $user */
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
            return redirect()->back()->with('error', 'Failed change password' . $th->getMessage());
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


    public function destroy(Instance $staff)
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
    public function destroy_group(Group $group){
        try {
            

            Gate::allows('is_member', [$group]);
            Gate::allows('modify_permission', [$group]);

            Storage::disk('public')->deleteDirectory($group->instance->folder_name . '/groups/' . $group->group_code);

            $group->delete();

            return redirect()->back()->with('success', 'Delete Success');
            
        }catch(\Exception $e) {
            return redirect()->back()->with('error', 'Error for Delete Group');

        }
    }
}
