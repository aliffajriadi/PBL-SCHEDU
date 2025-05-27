<?php

namespace App;

enum NotificationType: String
{
    case GroupNote = 'group_note';
    case GroupTask = 'group_task';
    case GroupSchedule = 'group_schedule';
    case Group = 'group';
    case PersonalTask = 'personal_task';

}
