<?php

namespace App\Policies;

use App\Models\GroupSchedule;
use App\Models\User;
use App\Models\MemberOf;
use App\Models\Group;

use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class GroupSchedulePolicy
{
    
    public function permission(User $user, GroupSchedule $schedule, Group $group)
    {
        return $schedule->group_id === $group->id && $user->uuid === $group->created_by
        ? Response::allow()
            : abort(403, 'You\re not allowed to access or modify this content');
    }

    public function create(User $user, Group $group)
    {
        return $user->uuid === $group->created_by
            ? Response::allow()
            : abort(403, 'You\'re not allowed to create this content');
    }

}
