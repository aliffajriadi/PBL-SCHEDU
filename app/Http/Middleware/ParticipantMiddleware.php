<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\NotificationStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ParticipantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $notifications = NotificationStatus::with('notification')->join('notifications', 'notification_statuses.notif_id', '=', 'notifications.id')->where('user_uuid', Auth::user()->uuid)->whereHas('notification', function ($model){
            $model->where('visible_schedule', '<=', Carbon::now('Asia/Jakarta')->toDateTimeString());  
        });

        session('notification_count', $notifications->count());

        return $next($request);
    }
}
