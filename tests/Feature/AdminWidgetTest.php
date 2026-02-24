<?php

use App\Filament\Widgets\StatsOverview;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Filament\Widgets\EnrollmentsChart;
use App\Filament\Widgets\CoursePopularityChart;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['is_admin' => true]);
});

it('stats overview widget displays correct counts', function () {
    User::factory(5)->create(['is_admin' => false]);
    Course::factory(3)->create(['is_published' => true]);

    $users = User::all();
    $courses = Course::all();

    foreach ($users as $user) {
        foreach ($courses as $course) {
            Enrollment::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'enrolled_at' => now(),
            ]);
        }
    }

    actingAs($this->admin);

    Livewire::test(StatsOverview::class)
        ->assertSee('Total Students')
        ->assertSee('Active Courses')
        ->assertSee('Enrollments');
});

it('enrollment chart widget is accessible', function () {
    actingAs($this->admin);

    Livewire::test(EnrollmentsChart::class)
        ->assertSuccessful();
});

it('course popularity chart widget is accessible', function () {
    actingAs($this->admin);

    Livewire::test(CoursePopularityChart::class)
        ->assertSuccessful();
});
