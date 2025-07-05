<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupTask;
use App\Models\GroupTaskSubmission;
use App\Models\MemberOf;
use App\Models\NotificationStatus;
use App\Models\PersonalSchedule;
use App\Models\PersonalTask;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        if(Auth::check()){
            NotificationController::refresh_notification();
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
    
        $notif = NotificationStatus::with('notification')->where('user_uuid', $user->uuid)->where('is_read', false);
        $personal_task = PersonalTask::where('user_uuid', $user->uuid);

        if($user->is_teacher === 0){
            $total_group_task = GroupTask::whereIn('group_id', MemberOf::where('user_uuid', $user->uuid)->pluck('group_id'))->count();
            $finished_group_task = GroupTaskSubmission::where('user_uuid', $user->uuid)->count();
    
            $data = [
                'user' => $user, 
                'role' => 'student',
                'user_data' => $user_data,
                'schedules' => PersonalSchedule::where('user_uuid',  $user->uuid)->get(),
                'uf_task_count' => (clone $personal_task)->where('is_finished', false)->count() + $total_group_task - $finished_group_task,
                'f_task_count' => (clone $personal_task)->where('is_finished', true)->count() + $finished_group_task,
                'notifications' => $notif->limit(3)->get(),
                'count_notif' =>$notif->count()
                
            ];
        }else {
            $data = [
                'user' => $user, 
                'role' => 'teacher',
                'user_data' => $user_data,
                'schedules' => PersonalSchedule::where('user_uuid',  $user->uuid)->get(),
                'uf_task_count' => (clone $personal_task)->where('is_finished', false)->count(),
                'f_task_count' => (clone $personal_task)->where('is_finished', true)->count(),
                'notifications' => $notif->limit(3)->get(),
                'count_notif' =>$notif->count()
            ];
        }
        // dd(Carbon::now()); 


        return view('teachStudent.dashboard',  compact('data'));
    }

    public function profile()
    {
        return view('profile', [
            'user_data' => Auth::user()->instance,
            'user' => Auth::user()
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
                'birth_date' => 'required|date',
                'is_teacher' => 'required|boolean',
                'profile_pic' => 'file'
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

    public function change_password(Request $request)
    {
        try {
            $request->validate([
                'old_password' => 'required',
                'password' => 'required|confirmed|max:255'
            ]);

            // dd($request->input('old_password'));

            if (!Hash::check($request->input('old_password'), Auth::user()->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Wrong Old Password'
                ]);
            }

            $user = Auth::user();

            $user->password = Hash::make($request->input('password'));
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

    public function update_profile(Request $request)
    {
        try{
            $request->validate([
                'profile_pic' => 'file',
                'email' => 'email|required'
            ]);
    
            $file_name = '';
            $user = Auth::user();

            if($request->hasFile('profile_pic')){
                
                $file = $request->file('profile_pic');

                $file_name = $user->uuid . '.' . $file->getClientOriginalExtension();

                $file->storeAs($user->instance->folder_name, $file_name, 'public');
            
                $user->profile_pic = $file_name;
            }
    
            $user->email = $request->input('email');
            $user->save();

            return redirect()->back();

        }catch(\Exception $e){
            return redirect()->back();
        }
    }
}
