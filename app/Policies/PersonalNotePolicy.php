<?php

namespace App\Policies;

use App\Models\PersonalNote;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PersonalNotePolicy
{
    public function own(User $user, PersonalNote $note)
    {
        return $user->uuid === $note->user_uuid
            ? Response::allow()
            :     abort(403, "You\'re not allowed to access and modify this content.");
            ; 
    }

}
