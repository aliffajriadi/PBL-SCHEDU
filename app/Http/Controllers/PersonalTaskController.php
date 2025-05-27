<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalTask;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PersonalTaskController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'datas' => PersonalTask::all()
        ]);
    }

    public function store(Request $request)
    {
        try{
                
            $field = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'deadline' => 'required|date'
            ]);

            $field['user_uuid'] = Auth::user()->uuid;

            $task = PersonalTask::create($field);

            $visible_schedule = $field['deadline'] < now()->setTimezone('Asia/Jakarta') ? now()->setTimezone('Asia/Jakarta') : $field['deadline'];

            $notif = NotificationController::store("Pengingat untuk '{$field['title']}'", $field['content'], PersonalTask::class, $task->id, true, $visible_schedule);

            return response()->json([
                'status' => true,
                'message' => 'New Task Added Successfully',
                'notif' => $notif
            ]);

        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }

    }

    public function update(Request $request, PersonalTask $api)
    {
        try{

            $field = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'deadline' => 'required|date'
            ]);

            $api->update($field);

            $notif = $api->notification()->where('is_reminder', true)->orderBy('created_at', 'DESC')->first();
            $now = now()->setTimezone('Asia/Jakarta');            

            $new_visible_schedule = Carbon::parse($field['deadline']) > $now ? $field['deadline'] : $now;

            if($notif->visible_schedule <= $now){
                NotificationController::store("Pengingat untuk '{$field['title']}'", $field['content'], PersonalTask::class, $api->id, true, $new_visible_schedule);
            }else{
                $notif->update([
                    'title' => "Pengingat untuk '{$field['title']}'",
                    'content' => $field['content'],
                    'visible_schedule' => $new_visible_schedule
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Task Updated Successfully'
            ]);

        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy(PersonalTask $api)
    {
        try{
            $notifications = $api->notification()->where('is_reminder', true)->where('visible_schedule', '>', now()->setTimezone('Asia/Jakarta'))->get();

            $notifications->each->delete();
            $api->delete();

            return response()->json([
                'status' => true,
                'message' => 'Task Deleted Successfully'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
