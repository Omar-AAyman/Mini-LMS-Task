<?php

namespace App\Policies;

use App\Models\LessonProgress;
use App\Models\User;

class LessonProgressPolicy
{
    public function update(User $user, LessonProgress $progress): bool
    {
        return $user->id === $progress->user_id;
    }

    public function view(User $user, LessonProgress $progress): bool
    {
        return $user->id === $progress->user_id || $user->is_admin;
    }
}
