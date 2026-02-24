<?php

namespace App\Actions;

use App\Mail\CourseCompletionMail;
use App\Models\Course;
use App\Models\CourseCompletion;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CompleteLessonAction
{
    public function __invoke(User $user, Lesson $lesson): void
    {
        Cache::lock("complete_lesson_{$user->id}_{$lesson->id}", 10)->block(5, function () use ($user, $lesson) {
            DB::transaction(function () use ($user, $lesson) {

                $progress = LessonProgress::firstOrCreate([
                    'user_id' => $user->id,
                    'lesson_id' => $lesson->id,
                ], [
                    'started_at' => now(),
                ]);

                if (! $progress->completed_at) {
                    $progress->update(['completed_at' => now()]);
                }

                $course = $lesson->course;
                $allLessonIds = $course->lessons()->pluck('id')->toArray();

                $completedLessonIds = $user->progress()
                    ->whereIn('lesson_id', $allLessonIds)
                    ->whereNotNull('completed_at')
                    ->pluck('lesson_id')
                    ->toArray();

                if (empty(array_diff($allLessonIds, $completedLessonIds))) {

                    $completion = CourseCompletion::firstOrCreate([
                        'user_id' => $user->id,
                        'course_id' => $course->id,
                    ], [
                        'completed_at' => now(),
                    ]);

                    if ($completion->wasRecentlyCreated) {
                        if (filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                            Mail::to($user->email)->send(new CourseCompletionMail($user, $course));
                        } else {
                            Log::warning("Course completion email not sent for Course ID {$course->id}. Invalid email for User ID {$user->id}: '{$user->email}'");
                        }
                    }
                }
            });
        });
    }
}
