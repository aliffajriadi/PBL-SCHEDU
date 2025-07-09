<?php

namespace App\Policies;

use App\Models\PersonalSchedule;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PersonalSchedulePolicy
{
    public function own(User $user, PersonalSchedule $schedule)
    {
        return $user->uuid === $schedule->user_uuid
            ? Response::allow()
            : abort(403, 'You\'re not allowed to access or modify this content.');
    }

}
