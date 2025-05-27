<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;
use App\Models\MemberOf;

use Illuminate\Auth\Access\Response;

class GroupPolicy
{
    public function is_member(User $user, Group $group)
    {
        return MemberOf::where('user_uuid', $user->uuid)->where('group_id', $group->id)->first()
            ? Response::allow()
            : abort(403, 'You\'re not a member of this group!');
    }

    public function modify_permission(User $user)
    {
        return $user->is_teacher 
            ? Response::allow()
            : abort(403, 'You don\'t have permission to modify this group ');
    }

    public function create(User $user)
    {
        return $user->is_teacher 
            ? Response::allow()
            : abort(403, 'You don\'t allowed to create a group');
    }
}
