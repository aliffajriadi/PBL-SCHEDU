<?php

namespace App\Http\Controllers;

use App\Models\NotificationStatus;
use App\Models\Notification;
use App\Models\MemberOf;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function show(notification $notification)
    {
        try {
            $status = NotificationStatus::where('notification_id', $notification->id)->where('user_uuid', Auth::user()->uuid)->firstOrFail();
            $status->is_read = true;
            $status->save();

            return response()->json([
                'status' => true,
                'data' => $notification
            ]);

        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);

        }
    }

    public function destroy(Group $group, NotificationStatus $notif_stat)
    {
        try {
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
