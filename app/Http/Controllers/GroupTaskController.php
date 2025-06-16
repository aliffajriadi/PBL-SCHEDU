<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\GroupTask;
use App\Models\GroupTaskSubmission;
use App\Models\GroupTaskUnit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GroupTaskController extends Controller
{
    public function __construct()
    {
        NotificationController::refresh_notification();
    }
    
    public function index(Request $request, Group $group)
    {
        try {
            $keyword = $request->query('keyword');

            $unit = GroupTaskUnit::where('group_id', $group->id);

            if ($keyword) {
                // Filter hanya unit yang punya task sesuai keyword
                $unit->whereHas('task', function ($query) use ($keyword) {
                    $query->where('title', 'LIKE', "%$keyword%");
                });

                // Hanya ambil task yang sesuai keyword
                $unit->with(['task' => function ($query) use ($keyword) {
                    $query->where('title', 'LIKE', "%$keyword%");
                }]);
            } else {
                // Ambil semua task kalau tidak ada keyword
                $unit->with('task');
            }

            return response()->json([
                'status' => true,
                'datas' => $unit->paginate(3),
                'keyword' => $keyword
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function dashboard(Group $group)
    {
        $role = session('role');
        $user = Auth::user();
        $user_data = [
            $user->name, $user->email
        ];
    
        $submissions = GroupTaskSubmission::where('user_uuid', $user->uuid)->orderByDesc('updated_at')->limit(3)->get();

        return view('group.group-task', [
            'role' => $role, 
            'user' => $user_data,
            'unit_datas' => GroupTaskUnit::where('group_id', $group->id)->orderBy('created_at')->get(),
            'submissions' => $submissions
        ]);
    }

    public function show(Group $group, GroupTask $api)
    {
        // Gate::allows('access', $api);

        try {

            $submission = $api->submission()->with('file')->orderBy('id', 'DESC');

            $datas = [
                'status' => true,
                'data' => $api,
            ];

            if(session('role') == 'teacher'){
                $datas['submission'] =  $submission->with('user:uuid,name')->get();
            }else{
                $datas['submission'] =  $submission->first();
                $datas['file'] = $datas['submission']->file ?? null;
            }

            return response()->json($datas);
            
        }catch(\Exception $e){
            return response()->json([
                'status' => false, 
                'message' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request, Group $group)
    {
        Gate::allows('create');

        try{
            $field = $request->validate([
                'title' => 'required|max:255',
                'unit_id' => 'required', 
                'content' => 'required',
                'deadline' => 'required|date'
            ]);

            $field['group_id'] = $group->id;
            $field['created_by'] = Auth::user()->uuid;

            $task = GroupTask::create($field);
            $visible_schedule = $field['deadline'] < now()->setTimezone('Asia/Jakarta') ? now()->setTimezone('Asia/Jakarta') : $field['deadline'];

            NotificationController::store(
                'Tugas grup baru dibuat', "Jadwal grup baru saja dibuat di grup $group->name dengan judul \"{$field['title']}\"", GroupTask::class, $task->id, false, now()->setTimezone('Asia/Jakarta'), $group->id
            );

            NotificationController::store(
                'Pengingat Tugas', "Jangan lupa dengan tugas \"{$field['title']}\" dari grup $group->name", GroupTask::class, $task->id, true, $visible_schedule, $group->id
            );

            return response()->json([
                'status' => true, 
                'message' => 'Task Added Successfully'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false, 
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, Group $group, GroupTask $api)
    {
        // Gate::allows('permission', [$api]);

        try{
            $field = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'deadline' => 'required|date'
            ]);

            $api->update($field);

            $now = now()->setTimezone('Asia/Jakarta');
            $notif = $api->notification()->where('is_reminder', true)->orderBy('created_at', 'DESC')->first();            


            $new_visible_schedule = $field['deadline'] > $now ? $field['deadline'] : $now;

            if($notif->visible_schedule <= $now){
                NotificationController::store(
                    'Pengingat Tugas', "Jangan lupa dengan tugas \"{$field['title']}\" dari grup $group->name", GroupTask::class, $api->id, true, $new_visible_schedule, $group->id
                );
            }else{
                $notif->update([
                    'title' => 'Pengingat Tugas',
                    'content' => "Jangan lupa dengan tugas \"{$field['title']}\" dari grup $group->name",
                    'visible_schedule' => $new_visible_schedule
                ]);
                $notif->save();
            }

            return response()->json([
                'status' => true, 
                'message' => 'Task Updates Successfully',
                'notification' => $api->notification
            ]);
            
        }catch(\Exception $e) {
            return response()->json([
                'status' => false, 
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy(String $group, GroupTask $api)
    {
        // Gate::allows('permission', [$api]);
        try{
            $notifications = $api->notification()->where('is_reminder', true)->orderBy('created_at', 'DESC')->first();
            
            $api->delete();
            
            // if($notifications){
            //     foreach($notifications as $notif){
            //         if($notif->visible_schedule > now()->setTimezone('Asia/Jakarta')) $notif->delete();
            //     }
            // }

            
            
            return response()->json([
                'status' => true, 
                'message' => 'Task Successfully Deleted',
                'notifications' => $notifications
            ]);
        }catch(\Exception $e) {
            return response()->json([
                'status' => false, 
                'message' => $e->getMessage()
            ]);
        }
    }
}
