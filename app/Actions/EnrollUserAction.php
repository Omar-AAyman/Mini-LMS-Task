<?php

namespace App\Actions;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Exception;

class EnrollUserAction
{
    public function __invoke(User $user, Course $course): ?Enrollment
    {
        if (! $course->is_published) {
            throw new Exception('Cannot enroll in a draft course.');
        }

        return Cache::lock("enroll_{$user->id}_{$course->id}", 10)->block(5, function () use ($user, $course) {
            return DB::transaction(function () use ($user, $course) {
                return Enrollment::firstOrCreate([
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                ], [
                    'enrolled_at' => now(),
                ]);
            });
        });
    }
}
