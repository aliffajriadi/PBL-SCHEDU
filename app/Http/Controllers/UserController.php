<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Hash;

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

            return response()->json([
                'status' => true,
                'message' => 'Logout Successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function insert_file(Request $request)
    {
        try {
            // Validasi file
            $request->validate([
                'student_list' => 'required|file|mimes:xlsx,xls,csv'
            ]);

            $instance_uuid = Auth::guard('staff')->user()->uuid;
            $default_password = Hash::make('password');

            $participant_list = [];

            // Load file Excel
            $spreadsheet = IOFactory::load($request->file('student_list')->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();

            $start_row = 2; // baris data, baris 1 biasanya header
            $end_row = $sheet->getHighestRow();

            for ($row = $start_row; $row <= $end_row; $row++) {
                $name = trim($sheet->getCell("A$row")->getValue());
                $email = trim($sheet->getCell("B$row")->getValue());
                $birthDateCell = $sheet->getCell("C$row")->getValue();
                $gender = trim($sheet->getCell("D$row")->getValue());
                $role = trim(strtolower($sheet->getCell("E$row")->getValue()));

                // Lewati baris kosong
                if (empty($name) && empty($email)) {
                    continue;
                }

                // Konversi tanggal lahir
                if (is_numeric($birthDateCell)) {
                    $birth_date = Date::excelToDateTimeObject($birthDateCell)->format('Y-m-d');
                } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', trim($birthDateCell))) {
                    $birth_date = trim($birthDateCell);
                } else {
                    throw new \Exception("Format birth date not failed $row. Nilai: '$birthDateCell'");
                }

                // Siapkan data user
                $data = [
                    'uuid' => Str::uuid(),
                    'name' => $name,
                    'email' => $email,
                    'birth_date' => $birth_date,
                    'gender' => $gender,
                    'is_teacher' => $role === 'teacher' ? 1 : 0,
                    'password' => $default_password,
                    'instance_uuid' => $instance_uuid,
                ];

                $participant_list[] = $data;
            }

            // Simpan ke database
            User::insert($participant_list);

            return redirect()->back()->with('success', 'Add  '. count($participant_list) . ' User Successfuly.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Add User Failed.');

        }
    }





    /**
     * Display a listing of the resource.
     */
    public function home()
    {   
        $user = Auth::user();
        $user_data = [$user->name, $user->email];
    
        return view('teachStudent.dashboard', [
            'user' => $user_data
        ]);
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

        if ($request->query('keyword')) {
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
            User::create($field);
            return redirect()->back()->with('success', 'Success Create Account');
        } catch (\Exception $e) {
            return redirect()->back()->with('success', 'Failed Create Account:' . $e);
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
        } catch (\Exception $e) {
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

            if (!Hash::check($request->input('old_password'), Auth::user()->password)) {
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
        } catch (\Exception $e) {
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

            return redirect()->back()->with('success', 'Success Deleted Data User');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e);
        }
    }
}
