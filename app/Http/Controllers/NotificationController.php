<?php

namespace App\Http\Controllers;

use App\Models\NotificationStatus;
use App\Models\Notification;
use App\Models\MemberOf;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class NotificationController extends Controller
{
    public function __construct()
    {
        self::refresh_notification();
    }

    public static function refresh_notification()
    {
        session()->put('notification_count', Auth::user()->notification()->where('is_read', 'false')->whereHas('notification', 
        function ($model)
            {
                $model->where('visible_schedule', '<=', Carbon::now('Asia/Jakarta')->toDateTimeString());  
            })->count()
        ); 
    }

    public static function store($title, $content, $type, $item_id, $is_reminder, $visible_schedule, $group_id = null)
    {
        try{
            $notif = Notification::create([
                'title' => $title,
                'content' => $content,
                'visible_schedule' => $visible_schedule,
                'group_id' => $group_id,
                'is_reminder' => $is_reminder,
                'type_type' => $type,
                'type_id' => $item_id
            ]);

            $notif_id = $notif->id;

            $now = Carbon::now();

            if($group_id != null){
                $member_ids = MemberOf::where('group_id', $group_id)->pluck('user_uuid');

                $notif_stats = [];

                foreach($member_ids as $id){
                    $notif_stats[] = [
                        'user_uuid' => $id,
                        'notif_id' => $notif_id,
                        'created_at' => $now,
                        'updated_at' => $now
                ];}

                NotificationStatus::insert($notif_stats);

            }else{
                NotificationStatus::create([
                    'notif_id' => $notif_id,
                    'user_uuid' => Auth::user()->uuid,
                ]);
                
            }

            return [
                'status' => true,
                'message' => 'Notifikasi berhasil dibuat'
            ];

        }catch(\Exception $e){
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function home()
    {
        $user = Auth::user();
        $user_data = [$user->name, $user->email];

        return view('notification', [
            'user' => $user_data,
            'role' => $user->is_teacher ? 'teacher' : 'student',
            'userData' => $user
        ]);
    }

    public function index(Request $request)
    {
        try {
            

            $notifications = NotificationStatus::with('notification')->
                join('notifications', 'notification_statuses.notif_id', '=', 'notifications.id')->
                where('user_uuid', Auth::user()->uuid)->
                whereHas('notification', function ($model){
                    $model->where('visible_schedule', '<=', Carbon::now('Asia/Jakarta')->toDateTimeString());  
                }
            );

            $keyword = $request->query('keyword') ?? false;
            $type = $request->query('type') ?? false;
            
            if($keyword) {
                $notifications->whereHas('notification', function($model)use($keyword) {
                    $model->where('title', 'LIKE', "%$keyword%")->orderByRaw(
                    "CASE
                            WHEN title LIKE ? THEN 1
                            WHEN title LIKE ? THEN 2
                            ELSE 3
                        END
                    ", ["$keyword%", "%$keyword%"]);
                });
            }else{
                $notifications->orderBy('notifications.visible_schedule', 'DESC');
            }

            if($type === 'personal'){
                $notifications->whereHas('notification', function($query) {
                    $query->where('group_id', '=', null);
                });
            } 

            if($type === 'group'){
                $notifications->whereHas('notification', function($query) {
                    $query->where('group_id', '!=', null);
                });
            }
            return response()->json([
                'status' => true,
                'datas' => $notifications->paginate(5),
                'keyword' => $keyword,
                'carbon_now' => Carbon::now()->toDateTimeString()
            ]);
            
        }catch(\Exception $e) {
            return response()->json([
                'status' => false, 
                'message' => $e->getMessage()
            ]);
        }
    
    }

    public function show(int $notification)
    {
        try {
            $status_query = NotificationStatus::where('notif_id', $notification)->where('user_uuid', Auth::user()->uuid);
            $status = $status_query->firstOrFail();
            
            Gate::allows('own', $status);

            if($status->is_read !== true){
                $status_query->update(['is_read' => true]);
                
            }

            session()->put('notification_count', Auth::user()->notification()->where('is_read', 'false')->whereHas('notification', 
            function ($model)
                {
                    $model->where('visible_schedule', '<=', Carbon::now('Asia/Jakarta')->toDateTimeString());  
                })->count()
            ); 

            return response()->json([
                'status' => true,
                'data' => $status_query->with('notification')->first(),
                'notif_count' => session('notification_count')
            ]);

        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);

        }
    }

    public function destroy(Group $group, int $api)
    {
        try {
            // Gate::allows('own', $notif);

            // return response()->json(['a' => $api]);

            $notif_stat = NotificationStatus::where('user_uuid', Auth::user()->uuid)->where('notif_id', $api);

            $notif_stat->delete();

            $message = 'notifikasi berhasil dihapus';

            if(NotificationStatus::where('notif_id', $api)->exists()){

                Notification::where('id', $api)->first()->delete();
            
                $message .= ' bersamaan dengan data template notifikasi';
            }

            return response()->json([
                'status' => true,
                'data' => $message
            ]);

        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);

        }
    }
}
