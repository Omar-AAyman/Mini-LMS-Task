<?php

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Level;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('calculates total duration of all lessons', function () {
    $level = Level::factory()->create();
    $course = Course::factory()->for($level)->create();

    Lesson::factory()->for($course)->create(['duration_seconds' => 100]);
    Lesson::factory()->for($course)->create(['duration_seconds' => 250]);

    expect($course->total_duration)->toBe(350);
});

it('formats duration into readable string', function () {
    $level = Level::factory()->create();
    $course = Course::factory()->for($level)->create();

    Lesson::factory()->for($course)->create(['duration_seconds' => 3660]);
    expect($course->formatted_duration)->toBe('1h 1m');

    $course2 = Course::factory()->for($level)->create();
    Lesson::factory()->for($course2)->create(['duration_seconds' => 120]);
    expect($course2->formatted_duration)->toBe('2m');
});

it('has correct relationships', function () {
    $level = Level::factory()->create();
    $course = Course::factory()->for($level)->create();

    expect($course->level)->toBeInstanceOf(Level::class);
    expect($course->lessons)->toBeInstanceOf(Collection::class);
    expect($course->enrollments)->toBeInstanceOf(Collection::class);
    expect($course->completions)->toBeInstanceOf(Collection::class);
});
