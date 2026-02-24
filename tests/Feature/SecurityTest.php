<?php

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Level;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

it('guests cannot access the admin panel', function () {
    $this->get('/admin')->assertRedirect('/admin/login');
});

it('non-admin users cannot access the admin panel', function () {
    $user = User::factory()->create(['is_admin' => false]);

    actingAs($user)
        ->get('/admin')
        ->assertForbidden();
});

it('guests can view free preview lessons', function () {
    $level = Level::factory()->create();
    $course = Course::factory()->for($level)->create(['is_published' => true]);
    $lesson = Lesson::factory()->for($course)->create(['is_free_preview' => true]);

    $this->get(route('lessons.show', [$course->slug, $lesson->slug]))
        ->assertSuccessful();
});

it('guests are redirected when accessing pro lessons', function () {
    $level = Level::factory()->create();
    $course = Course::factory()->for($level)->create(['is_published' => true]);
    $lesson = Lesson::factory()->for($course)->create(['is_free_preview' => false]);

    $this->get(route('lessons.show', [$course->slug, $lesson->slug]))
        ->assertRedirect(route('login'));
});

it('authenticated users must be enrolled to view pro lessons', function () {
    $user = User::factory()->create(['is_admin' => false]);
    $level = Level::factory()->create();
    $course = Course::factory()->for($level)->create(['is_published' => true]);
    $lesson = Lesson::factory()->for($course)->create(['is_free_preview' => false]);

    actingAs($user)
        ->get(route('lessons.show', [$course->slug, $lesson->slug]))
        ->assertRedirect(route('courses.show', $course->slug));
});
