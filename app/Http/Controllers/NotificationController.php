<?php

namespace App\Http\Controllers;

use App\Models\NotificationStatus;
use App\Models\Notification;
use App\Models\MemberOf;
use App\Models\Group;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class NotificationController extends Controller
{
    public static function store($title, $content, $visible_schedule = null, $group_id = null)
    {
        try{
            $notif = Notification::create([
                'title' => $title,
                'content' => $content,
                'visible_schedule' => $visible_schedule,
                'group_id' => $group_id
            ]);

            $notif_id = $notif->id;
    
            if($group_id != null){
                $member_ids = MemberOf::where('group_id', $group_id)->pluck('user_uuid');

                $notif_stats = [];

                foreach($member_ids as $id){
                    $notif_stats[] = [
                        'user_uuid' => $id,
                        'notif_id' => $notif_id
                    ];
                }

                NotificationStatus::insert($notif_stats);

            }else{
                NotificationStatus::create([
                    'notification_id' => $notif->id,
                    'user_uuid' => Auth::user()->uuid
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

    public function index(Request $request)
    {
        try {
            $notifications = NotificationStatus::with('notification')->where('user_uuid', Auth::user()->uuid);
            $keyword = $request->query('keyword') ?? false;
            $type = $request->query('type') ?? false;
            
            if($keyword) {
                $notifications->whereHas('notification', function($model)use($keyword) {
                    // global $keyword;
                    $model->where('title', 'LIKE', "%$keyword%")->orderByRaw(
                    "CASE
                            WHEN title LIKE ? THEN 1
                            WHEN title LIKE ? THEN 2
                            ELSE 3
                        END
                    ", ["$keyword%", "%$keyword%"]);
                });
            }

            if($type === 'personal'){
                $notifications->whereHas('notification', function($query) {
                    $query->where('group_id', '==', null);
                });
            } 

            if($type === 'group'){
                $notifications->whereHas('notification', function($query) {
                    $query->where('group_id', '!=', null);
                });
            } 

            return response()->json([
                'status' => true,
                'datas' => $notifications->get(),
                'keyword' => $keyword
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
                // $status->save();
            }

            $notif_data = Notification::where('id', $notification)->first();

            return response()->json([
                'status' => true,
                'data' => $notif_data
            ]);

        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);

        }
    }

    public function destroy(Group $group, Notification $notif)
    {
        try {
            Gate::allows('own', $notif);
            
            $notif_stat = NotificationStatus::where('user_uuid', Auth::user()->uuid)->where('notif_id', $notif->id)->first();

            $notif_stat->delete();

            $message = 'notifikasi berhasil dihapus';

            if(NotificationStatus::where('notification_id', $notif_stat->id)->exists()){
                Notification::where('id', $notif_stat->id)->first()->delete();
            
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
