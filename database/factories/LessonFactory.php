<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LessonFactory extends Factory
{
    protected $model = Lesson::class;

    public function definition(): array
    {
        $title = fake()->sentence(4);
        return [
            'course_id' => Course::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Placeholder
            'duration_seconds' => rand(300, 3600),
            'is_free_preview' => fake()->boolean(20),
            'order' => 0,
        ];
    }
}
