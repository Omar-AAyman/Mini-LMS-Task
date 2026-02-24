<?php

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Level;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->userA = User::factory()->create();
    $this->userB = User::factory()->create();
});

it('prevents users from viewing others enrollments', function () {
    $level = Level::factory()->create();
    $course = Course::factory()->for($level)->create();

    $enrollment = Enrollment::create([
        'user_id' => $this->userB->id,
        'course_id' => $course->id,
        'enrolled_at' => now(),
    ]);

    expect($this->userA->can('view', $enrollment))->toBeFalse();
    expect($this->userB->can('view', $enrollment))->toBeTrue();
});

it('prevents users from updating others lesson progress', function () {
    $lesson = Lesson::factory()->create();
    $progress = LessonProgress::create([
        'user_id' => $this->userB->id,
        'lesson_id' => $lesson->id,
        'started_at' => now(),
    ]);

    expect($this->userA->can('update', $progress))->toBeFalse();
    expect($this->userB->can('update', $progress))->toBeTrue();
});

it('prevents users from viewing others message details', function () {
    $lesson = Lesson::factory()->create();
    $progress = LessonProgress::create([
        'user_id' => $this->userB->id,
        'lesson_id' => $lesson->id,
        'started_at' => now(),
    ]);

    expect($this->userA->can('view', $progress))->toBeFalse();
    $admin = User::factory()->create(['is_admin' => true]);
    expect($admin->can('view', $progress))->toBeTrue();
});
