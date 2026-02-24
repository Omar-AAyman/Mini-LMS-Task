<?php

namespace App\Policies;

use App\Models\Enrollment;
use App\Models\User;

class EnrollmentPolicy
{
    public function view(User $user, Enrollment $enrollment): bool
    {
        return $user->id === $enrollment->user_id || $user->is_admin;
    }

    public function update(User $user, Enrollment $enrollment): bool
    {
        return $user->id === $enrollment->user_id;
    }
}
