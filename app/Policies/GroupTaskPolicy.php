<?php

namespace App\Policies;

use App\Models\GroupTask;
use App\Models\Group;
use App\Models\User;
use App\Models\MemberOf;
use Illuminate\Auth\Access\Response;

class GroupTaskPolicy
{
    public function access(User $user, GroupTask $task)
    {
        return MemberOf::where('user_uuid', $user->uuid)->where('group_id', $task->group_id)->first() 
            ? Response::allow()
            : abort(403, 'You\'re not allowed to access this content');
    }

    public function permission(User $user, GroupTask $task)
    {
        return MemberOf::where('user_uuid', $user->uuid)->where('group_id', $task->group_id)->first() 
        && $user->is_teacher 
            ? Response::allow()
            : abort(403, 'You\'re not allowed to modify this content');
    }

    public function create(User $user, Group $group)
    {
        return $user->uuid === $group->creatd_by
            ? Response::allow()
            : abort(403, 'You\'re not allowed to create this content');
    }
}
