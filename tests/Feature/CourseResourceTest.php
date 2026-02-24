<?php

use App\Models\Course;
use App\Models\Level;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Filament\Facades\Filament;
use App\Filament\Resources\CourseResource\Pages\CreateCourse;
use App\Filament\Resources\CourseResource\RelationManagers\LessonsRelationManager;
use App\Filament\Resources\CourseResource\Pages\EditCourse;
use Illuminate\Database\QueryException;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['is_admin' => true]);
    $this->level = Level::factory()->create(['name' => 'Beginner', 'slug' => 'beginner']);
});

it('lists courses in filament admin', function () {
    $course = Course::factory()->for($this->level)->create(['title' => 'Test Course', 'is_published' => true]);

    actingAs($this->admin)
        ->get('/admin/courses')
        ->assertSuccessful()
        ->assertSee('Test Course');
});

it('can create a course with filament', function () {
    actingAs($this->admin);

    Filament::setCurrentPanel(Filament::getPanel('admin'));

    Livewire::test(CreateCourse::class)
        ->fillForm([
            'level_id' => $this->level->id,
            'title' => 'New Laravel Course',
            'slug' => 'new-laravel-course',
            'description' => 'Learn Laravel from scratch.',
            'is_published' => true,
        ])
        ->call('create')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('courses', ['slug' => 'new-laravel-course']);
});

it('enforces unique slug on courses', function () {
    Course::factory()->for($this->level)->create(['slug' => 'duplicate-slug']);

    expect(fn () => Course::factory()->for($this->level)->create(['slug' => 'duplicate-slug']))
        ->toThrow(QueryException::class);
});

it('lessons relation manager can create a lesson', function () {
    $course = Course::factory()->for($this->level)->create();
    actingAs($this->admin);

    Filament::setCurrentPanel(Filament::getPanel('admin'));

    Livewire::test(
        LessonsRelationManager::class,
        ['ownerRecord' => $course, 'pageClass' => EditCourse::class]
    )
        ->callTableAction('create', data: [
            'title' => 'Intro Lesson',
            'slug' => 'intro-lesson',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'duration_seconds' => 300,
            'is_free_preview' => true,
            'order' => 1,
        ])
        ->assertHasNoTableActionErrors();

    $this->assertDatabaseHas('lessons', ['slug' => 'intro-lesson', 'course_id' => $course->id]);
});
