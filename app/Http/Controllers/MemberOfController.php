<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\MemberOf;
use App\Models\GroupNote;
use App\Models\GroupSchedule;
use App\Models\GroupTask;
use App\Models\Notification;
use App\Models\NotificationStatus;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberOfController extends Controller
{
    public function index(Group $group)
    {
        $role = session('role');
        $user = Auth::user();
        $user_data = [
            $user->name, $user->email
        ];
        
        $members = MemberOf::with('user:uuid,name,email')->where('user_uuid', '!=', $group->created_by)->where('group_id', $group->id)->where('verified', true)->get();
        $pending_requests = MemberOf::with('user:uuid,name,email')->where('user_uuid', '!=', $group->created_by)->where('group_id', $group->id)->where('verified', false)->get();

        return view('group.group-settings', [
            'role' => $role, 
            'user' => $user_data,
            'members' => $members,
            'pending_requests' => $pending_requests,
            'group_name' => $group->name,
            'group' => $group,
            'userData' => $user
        ]);
    }

    // masuk ke grup
    public function join_group(Request $request)
    {
        try {

            $group = Group::where('group_code', $request->input('group_code'))->where('instance_uuid', Auth::user()->instance_uuid);

            if(!$group->exists()){
                throw new \Exception('This group not exists in your instance');
            }

            $member = MemberOf::where('group_id', $group->first()->id)->where('user_uuid', Auth::user()->uuid);

            if($member->exists()){
                throw new \Exception('You have already joined this Group');
            }

            $user = Auth::user();

            MemberOf::create([
                'user_uuid' => $user->uuid,
                'group_id' => $group->first()->id,
                'verified' => false
            ]);

            NotificationController::store("Permintaan baru bergabung ke grup {$group->name}.", 
                "{$user->name} mengajukan permintaan bergabung ke dalam grup {$group->name}. Approve pada group settings untuk menyetujuinya dan Reject untuk menolaknya bergabung ke dalam group.", 
                Group::class,
                $group->id, 
                false,
                now(),
                target_id: $group->created_by
            );

            return redirect()->back();         

        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function join_link(Request $request, string $group_code)
    {
        try {

            if(!Auth::check()) return redirect('/login')->with('error', 'Harus login sebelum join');

            $user = Auth::user();

            if($user->is_teacher === 1){
                return redirect('/group')->with('error', 'Guru tidak bisa bergabung ke grup');
                throw new \Exception('Guru tidak bisa bergabung ke grup');
            }          

            $group = Group::where('group_code', $group_code)->first();
            
            if($group === null){

                return redirect('/group')->with('error', 'Group ini tidak ada di instansi anda');
                throw new \Exception('This group not exists in your instance');
            }

            $member = MemberOf::where('group_id', $group->first()->id)->where('user_uuid', Auth::user()->uuid);

            if($member->exists()){
                return redirect('/group')->with('error', 'Kamu sudah join masuk ke dalam group ini');
                throw new \Exception('You have already joined this Group');
            }

            MemberOf::create([
                'user_uuid' => Auth::user()->uuid,
                'group_id' => $group->id,
                'verified' => false
            ]);

            NotificationController::store("Permintaan baru bergabung ke grup {$group->name}.", 
                "{$user->name} mengajukan permintaan bergabung ke dalam grup {$group->name}. Approve pada group settings untuk menyetujuinya dan Reject untuk menolaknya bergabung ke dalam group.", 
                Group::class,
                $group->id, 
                false,
                now(),
                target_id: $group->created_by
            );

            return redirect('group')->with('success', 'Berhasil mengajukan permintaan bergabung ke dalam grup');         

        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    // diverifikasi 

    public function verifying(Group $group, MemberOf $member_of)
    {
        try {
            $member_of->verified = true;
            $member_of->save(); 

            return redirect()->back();
        
        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        
        }
    }


    // tidak diverifikasi, dikeluarkan, mengeluarkan diri 

    public function leave_group(Request $request, Group $group, MemberOf $member_of)
    {
        try {

            $member_of->delete();
            
            return redirect()->back();

            return response()->json([
                'status' => true,
                'message' => 'Leave the Group'
            ]);

        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    // tambahkan if kalau mau hapus catatan grup nanti file catatan juga ikut ke hapus dan pada tugas semua data file tugas pengumpulan ikut ke hapus
    public function delete_all(Request $request, Group $group, String $table)
    {
        try{

            $request->validate([
                'password' => 'required|string'
            ]);

            $password = $request->input('password');

            $user = Auth::user();

            if(!Hash::check($password, $user->password)){
                throw new \Exception('Wrong input password');
            }


            $table_name = match ($table) {
                'notes' => 'group_notes',
                'schedules' => 'group_schedules',
                'tasks' => 'group_task_units',
                'members' => 'member_ofs',
                'pending' => 'member_ofs'
            };

            $query = DB::table($table_name)->where('group_id', $group->id);

            if($table === 'members'){
                $query = $query->where('verified', true)->where('user_uuid', '!=', Auth::user()->uuid);
            }elseif($table === 'pending'){
                $query = $query->where('verified', false)->where('user_uuid', '!=', Auth::user()->uuid);
            }

            $query->delete();

            $pesan = match($table) {
                'notes' => 'catatan',
                'schedules' => 'jadwal',
                'tasks' => 'unit dan tugas',
                'members' => 'anggota di dalam grup',
                'pending' => 'semua permintaan masuk ke dalam grup'
            };

            return redirect()->back()->with('success', 'berhasil menghapus semua ' . $pesan);

        }catch(\Exception $e){
            return redirect()->back()->with('error', 'gagal menjalankan fungsi: ' . $e->getMessage() );
            
        }
    }
}
