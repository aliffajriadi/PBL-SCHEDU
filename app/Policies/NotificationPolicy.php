<?php

namespace App\Policies;

use App\Models\Notification;
use App\Models\NotificationStatus;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NotificationPolicy
{
    public function own(User $user, NotificationStatus $notif)
    {
        return $notif
            ? Response::allow()
            : abort(403, 'You\'re not allowed to access and modify this content');
    }

}
