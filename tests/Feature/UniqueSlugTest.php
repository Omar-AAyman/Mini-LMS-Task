<?php

use App\Models\Course;
use App\Models\Level;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('enforces unique slug on courses', function () {
    $level = Level::factory()->create();
    $slug = 'unique-course-slug';

    Course::factory()->create([
        'level_id' => $level->id,
        'slug' => $slug,
    ]);

    $this->expectException(QueryException::class);

    Course::factory()->create([
        'level_id' => $level->id,
        'slug' => $slug,
    ]);
});

it('ensures slug remains unique even with soft deletes (base case)', function () {
    $level = Level::factory()->create();
    $slug = 'unique-course-slug';

    $course = Course::factory()->create([
        'level_id' => $level->id,
        'slug' => $slug,
    ]);

    $course->delete();

    $this->expectException(QueryException::class);

    Course::factory()->create([
        'level_id' => $level->id,
        'slug' => $slug,    
    ]);
});
