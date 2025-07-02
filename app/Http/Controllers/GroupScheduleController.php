<?php

namespace App\Http\Controllers;

use App\Models\GroupSchedule;
use App\Models\Group;
use App\Models\Notification;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GroupScheduleController extends Controller
{
    public function __construct()
    {
        NotificationController::refresh_notification();
    }
    
    public function home()
    {
        $role = session('role');
        $user = Auth::user();
        $user_data = [
            $user->name, $user->email
        ];
    
        return view('group.group-schedule', [
            'role' => $role, 
            'user' => $user_data,
            'userData' => $user
        ]);
    }

    public function index(Request $request, Group $group)
    {
        try {

            $schedules = GroupSchedule::where('group_id', $group->id)->orderByDesc('created_at');

            $keyword = $request->query('keyword') ?? false;

            if($keyword) {
                $schedules->where('title', 'LIKE', "%$keyword%")->orderByRaw(
                    "CASE 
                            WHEN title LIKE ? THEN 1
                            WHEN title LIKE ? THEN 2
                            ELSE 3
                        END", ["$keyword%", "%$keyword%"]
                );
            }

            return response()->json([
                'calendar' => $schedules->get(),
                'datas' => $schedules->paginate(1),
                'status' => true,
            ]);
            
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request, Group $group)
    {
        // Gate::allows('create');
        
        try {
            $field = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'start_datetime' => 'required',
                'end_datetime' => 'required'
            ]);

            $field['group_id'] = $group->id;

            $schedule = GroupSchedule::create($field);
            $now = now()->setTimezone('Asia/Jakarta');

            $username = Auth::user()->name;
            NotificationController::store('Jadwal Group Baru', "$username baru saja membuat jadwal untuk grup $group->name", GroupSchedule::class, $schedule->id, false, $now, $group->id);

            $date = Carbon::parse($field['start_datetime']);
            $end_date = Carbon::parse($field['end_datetime']);
            $title = $field['title'];

            while($date < $now) $date->addDay();

            while($date <= $end_date){
                NotificationController::store('Pengingat Jadwal Grup', "Ada jadwal \"$title\" hari ini pada Jam {$date->format('h:i')}", GroupSchedule::class, $schedule->id, true, $date->toDateTimeString(), $group->id);
                $date->addDay();
            }

            return response()->json([
                'status' => true,
                'message' => 'New Schedule Successfully Added'
            ]);

        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, Group $group, GroupSchedule $api)
    {
        try{
            // Gate::allows('permission', [$api]);

            $field = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'start_datetime' => 'required',
                'end_datetime' => 'required'
            ]);

            $now = now()->setTimezone('Asia/Jakarta');
            $notifications = $api->notification()->where('is_reminder', true)->where('visible_schedule', '>', $now)->get();
            $notifications->each->delete();

            $date = Carbon::parse($field['start_datetime']);
            $end_date = Carbon::parse($field['end_datetime']);
            $title = $field['title'];
            
            while($date < $now) $date->addDay();

            while($date <= $end_date){
                NotificationController::store('Pengingat Jadwal Grup', "Ada jadwal \"$title\" hari ini pada Jam {$date->format('h:i')}", GroupSchedule::class, $api->id, true, $date->toDateTimeString(), $group->id);
                $date->addDay();
            }

            $api->update($field);
            $api->save();
            
            return response()->json([
                'status' => true,
                'message'=> 'Group Schedule Updated Successfully'
            ]);

        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message'=> $e->getMessage()
            ]);
        }
    }

    public function destroy(Request $request, Group $group, GroupSchedule $api)
    {
        try {
            // Gate::allows('permission', [$api]);

            $notifications = $api->notification()->where('is_reminder', true)->where('visible_schedule', '>', now()->setTimezone('Asia/Jakarta'))->get();

            $api->delete();
            $notifications->each->delete();


            return response()->json([
                'status' => true,
                'message'=> 'Schedule Deleted Successfully'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message'=> $e->getMessage()
            ]);
        }


    }
}
