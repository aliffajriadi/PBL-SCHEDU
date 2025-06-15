<?php

namespace App\Http\Controllers;

use App\Models\PersonalSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalScheduleController extends Controller
{
    public function __construct()
    {
        NotificationController::refresh_notification();
    }
    
    public function home()
    {
        $user = Auth::user();
        $user_data = [$user->name, $user->email];
    
        return view('teachStudent.schedule', [
            'user' => $user_data
        ]);
    }

    public function index(Request $request)
    {
        $schedules = PersonalSchedule::query()->where('user_uuid', Auth::user()->uuid)->orderByDesc('created_at');
        
        $keyword = $request->query('keyword');

        if($keyword){
            $keyword = '%' . $keyword . '%';
            $schedules->where('title', 'like', $keyword); 
        }

        return response()->json([
        'datas' => $schedules->paginate(5),
            'calendar' => $schedules->get()
        ]);

    }
    
    public function store(Request $request)
    {
        try {
            $field = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'start_datetime' => 'required',
                'end_datetime' => 'required'
            ]);

            $field['user_uuid'] = Auth::user()->uuid;

            $schedule = PersonalSchedule::create($field);
            $now = now()->setTimezone('Asia/Jakarta');

            $date = Carbon::parse($field['start_datetime']);
            $end_date = Carbon::parse($field['end_datetime']);
            $title = $field['title'];

            while($date < $now) $date->addDay();

            $notifications = [];

            while($date <= $end_date){
                $notifications[] = NotificationController::store('Pengingat Jadwal Personal', "Ada jadwal \"$title\" hari ini pada Jam {$date->format('h:i')}", PersonalSchedule::class, $schedule->id, true, $date->toDateTimeString());
                $date->addDay();
            }

            return response()->json([
                'status' => true,
                'message' => 'New Schedule Successfully Added',
                'notifications' => $notifications
            ]);

        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, PersonalSchedule $api)
    {
        try {
            $field = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'start_datetime' => 'required',
                'end_datetime' => 'required'
            ]);

            $api->update($field);
            $now = now()->setTimezone('Asia/Jakarta');

            $date = Carbon::parse($field['start_datetime']);
            $end_date = Carbon::parse($field['end_datetime']);
            $title = $field['title'];

            $old_notifications = $api->notification()->where('is_reminder', true)->where('visible_schedule', '>', $now)->get();
            $old_notifications->each->delete();

            while($date < $now) $date->addDay();

            $notifications = [];

            while($date <= $end_date){
                $notifications[] = NotificationController::store('Pengingat Jadwal Personal', "Ada jadwal \"$title\" hari ini pada Jam {$date->format('h:i')}", PersonalSchedule::class, $api->id, true, $date->toDateTimeString());
                $date->addDay();
            }

            return response()->json([
                'status' => true,
                'message' => 'Schedule Updated Successfully',
                'notifications' => $notifications
            ]);

        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy(PersonalSchedule $api)
    {
        try {
            $old_notifications = $api->notification()->where('is_reminder', true)->where('visible_schedule', '>', now()->setTimezone('Asia/Jakarta'))->get();
            $api->delete();
            $old_notifications->each->delete();
            
            return response()->json([
                'status' => true,
                'message' => 'Schedule Deleted Successfully',
            ]);

        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
