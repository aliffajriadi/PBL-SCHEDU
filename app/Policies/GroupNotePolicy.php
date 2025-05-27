<?php

namespace App\Policies;

use App\Models\GroupNote;
use App\Models\MemberOf;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GroupNotePolicy
{
    public function is_member(User $user, GroupNote $note)
    {
        return MemberOf::where('uuid', $user->uuid)->where('group_id', $note->group_id)->first()
            ? Response::allow()
            : abort(403, 'Can\'t access this content');
    }

    public function modify_permission(User $user)
    {
        return $user->is_teacher
            ? Response::allow()
            : abort(403, 'You\'re not allowed to modify this content');
    }

    public function create(User $user)
    {
        return $user->is_teacher
            ? Response::allow()
            : abort(403, 'You\'re not allowed to create this content');
    }

}
