<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalTask;
use Illuminate\Support\Facades\Auth;

class PersonalTaskController extends Controller
{
    public function index()
    {

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

            NotificationController::store("Pengingat untuk '{$field['title']}'", $field['content'], PersonalTask::class, $task->id, true, $field['deadline']);

            return response()->json([
                'status' => false,
                'message' => 'New Task Added Successfully'
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

            $notif = $api->notification->where('is_reminder', true)->orderBy('created_at', 'DESC')->first();
            $now = now()->setTimezone('Asia/Jakarta');            

            $new_visible_schedule = $field['deadline'] > $now ? $field['deadline'] : $now;

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

    public function destroy()
    {

    }
}
