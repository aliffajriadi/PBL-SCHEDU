<?php

namespace App\Policies;

use App\Models\PersonalTask;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PersonalTaskPolicy
{
    public function own(User $user, PersonalTask $task)
    {
        return $user->uuid === $task->user_uuid
            ? Response::allow()
            : abort(403, 'You\'re not allowed to access or modify this content.');
    }
}
