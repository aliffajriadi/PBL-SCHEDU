<?php

namespace App\Policies;

use App\Models\GroupSchedule;
use App\Models\User;
use App\Models\MemberOf;

use Illuminate\Auth\Access\Response;

class GroupSchedulePolicy
{
    public function permission(User $user, GroupSchedule $schedule)
    {
        return MemberOf::where('user_uuid', $user->uuid)->where('group_id', $schedule)->first() 
        && $user->is_teacher 
            ? Response::allow()
            : abort(403, 'You\re not allowed to access or modify this content');
    }

    public function create(User $user)
    {
        return $user->is_teacher
            ? Response::allow()
            : abort(403, 'You\'re not allowed to create this content');
    }
}
