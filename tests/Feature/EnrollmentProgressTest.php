<?php

use App\Actions\CompleteLessonAction;
use App\Actions\EnrollUserAction;
use App\Mail\CourseCompletionMail;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Level;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin  = User::factory()->create(['is_admin' => true]);
    $this->user   = User::factory()->create(['is_admin' => false]);
    $level        = Level::factory()->create(['slug' => 'beginner']);
    $this->course = Course::factory()->for($level)->create(['is_published' => true]);
});

it('shows enrollments in admin panel', function () {
    $enrollment = Enrollment::create([
        'user_id'     => $this->user->id,
        'course_id'   => $this->course->id,
        'enrolled_at' => now(),
    ]);

    actingAs($this->admin)
        ->get('/admin/enrollments')
        ->assertSuccessful();
});

it('enrollment is idempotent - enrolling twice creates only one record', function () {
    $action = app(EnrollUserAction::class);
    $action($this->user, $this->course);
    $action($this->user, $this->course);

    expect(Enrollment::where('user_id', $this->user->id)->where('course_id', $this->course->id)->count())
        ->toEqual(1);
});

it('completing all lessons creates course_completion and sends email once', function () {
    Mail::fake();

    $lessons = Lesson::factory(3)->for($this->course)->create();

    $lessons->each(fn ($l, $i) => $l->update(['order' => $i + 1]));
    Enrollment::create(['user_id' => $this->user->id, 'course_id' => $this->course->id, 'enrolled_at' => now()]);

    $action = app(CompleteLessonAction::class);

    foreach ($lessons as $lesson) {
        $action($this->user, $lesson);
    }

    $this->assertDatabaseHas('course_completions', [
        'user_id'   => $this->user->id,
        'course_id' => $this->course->id,
    ]);

    Mail::assertQueued(CourseCompletionMail::class, 1);

    $action($this->user, $lessons->first());
    Mail::assertQueued(CourseCompletionMail::class, 1);
});

it('progress percentage is isolated per user', function () {
    $otherUser = User::factory()->create(['is_admin' => false]);
    $lessons   = Lesson::factory(4)->for($this->course)->create();

    Enrollment::create(['user_id' => $this->user->id,  'course_id' => $this->course->id, 'enrolled_at' => now()]);
    Enrollment::create(['user_id' => $otherUser->id, 'course_id' => $this->course->id, 'enrolled_at' => now()]);

    $action = app(CompleteLessonAction::class);
    $action($this->user, $lessons->first());

    $userCompleted  = $this->user->progress()->whereIn('lesson_id', $lessons->pluck('id'))->whereNotNull('completed_at')->count();
    $otherCompleted = $otherUser->progress()->whereIn('lesson_id', $lessons->pluck('id'))->whereNotNull('completed_at')->count();

    expect($userCompleted)->toBe(1)
        ->and($otherCompleted)->toBe(0);
});
