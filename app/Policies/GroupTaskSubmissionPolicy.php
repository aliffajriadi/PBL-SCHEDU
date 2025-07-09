<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\GroupTask;
use App\Models\GroupTaskSubmission;
use App\Models\MemberOf;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GroupTaskSubmissionPolicy
{
    public function show(User $user, GroupTaskSubmission $submission, Group $group)
    {
        return $user->uuid === $submission->user_uuid || $user->uuid === $group->created_by 
            ? Response::allow()
            : abort(403, 'This submission doesn\'t belong to you!');
    }

    public function create_submission(User $user, GroupTask $task)
    {
        return !$user->is_teacher && MemberOf::where('user_uuid', $user->uuid)->where('group_id', $task->group_id)->exists() 
            ? Response::allow()
            : abort(403, 'Your\'e not allowed to submit on this task!');      
    }

    public function owning(User $user, GroupTaskSubmission $submission)
    {
        return $submission->user_uuid === $user->uuid  
            ? Response::allow()
            : abort(403, 'This submission does\'nt belong to you');
    }

    public function scoring(User $user, Group $group)
    {
        return $user->uuid === $group->created_by 
            ? Response::allow()
            : abort(403, 'You not allowed to score this submission!');
    }

    public function own_file(User $user, GroupTaskSubmission $submission)
    {
        return $user->uuid === $submission->user_uuid
            ? Response::allow()
            : abort(403, 'You\'re not allowed to modify this file!');
    }
}
