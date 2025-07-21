<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalTask;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PersonalTaskController extends Controller
{
    public function __construct()
    {
        NotificationController::refresh_notification();
    }
    
    public function home()
    {
         $user = Auth::user();
            $user_data = [$user->name, $user->email];

            return view('teachStudent.task', [
                'user' => $user_data,
                'userData' => $user

            ]);
    }

    public function index(Request $request)
    {
        $schedules = PersonalTask::query()->where('user_uuid', Auth::user()->uuid)->orderByDesc('created_at');
        
        $keyword = $request->query('keyword');

        if($keyword){
            $keyword = '%' . $keyword . '%';
            $schedules->where('title', 'like', $keyword); 
        }

        return response()->json([
            'datas' => $schedules->get(),
            'keyword' => $keyword
        ]);
    }

    public function store(Request $request)
    {

        DB::beginTransaction();

        try{
                
            $field = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'deadline' => 'required|date'
            ]);

            $field['user_uuid'] = Auth::user()->uuid;

            $task = PersonalTask::create($field);

            $visible_schedule = Carbon::parse($field['deadline']) < now()->setTimezone('Asia/Jakarta')->addHour() ? now()->setTimezone('Asia/Jakarta') : Carbon::parse($field['deadline'])->subHour();

            $notif = NotificationController::store("Reminder for '{$field['title']}'", $field['content'], PersonalTask::class, $task->id, true, $visible_schedule);

            // $visible_schedule = $field['deadline'] < now()->setTimezone('Asia/Jakarta') ? now()->setTimezone('Asia/Jakarta') : $field['deadline'];

            // $notif = NotificationController::store("Pengingat untuk '{$field['title']}'", $field['content'], PersonalTask::class, $task->id, true, $visible_schedule);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'New Task Added Successfully',
                'notif' => $notif
            ]);

        }catch(\Exception $e){
            
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }

    }

    public function update(Request $request, PersonalTask $api)
    {
        DB::beginTransaction();

        try{
            Gate::allows('own', [$api]);

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

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Task Updated Successfully'
            ]);

        }catch(\Exception $e){

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy(PersonalTask $api)
    {
        DB::beginTransaction();

        try{
            Gate::allows('own', [$api]);

            $notifications = $api->notification()->where('is_reminder', true)->where('visible_schedule', '>', now()->setTimezone('Asia/Jakarta'))->get();

            $notifications->each->delete();
            $api->delete();
    
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Task Deleted Successfully'
            ]);
        }catch(\Exception $e){
            
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function set_finish(Request $request, PersonalTask $task)
    {
        DB::beginTransaction();

        try{
            Gate::allows('own', [$task]);

            $field = $request->validate([
                'is_finished' => 'required'
            ]);

            $task->update($field);
            
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'tugasnya sudah selesai dikerjakan'
            ]);
            
        }catch(\Exception $e){

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function reset_finish(PersonalTask $task)
    {
        DB::beginTransaction();

        try{
            Gate::allows('own', [$task]);
            
            $task->update([
                'is_finished' => false
            ]);

            DB::commit();
            
            return response()->json([
                'status' => true,
                'message' => 'ada yang belum selesi dikerjakan?'
            ]);
            
        }catch(\Exception $e){
            
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    
}
