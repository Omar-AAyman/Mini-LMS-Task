<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Level;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(3);
        return [
            'level_id' => Level::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraph(),
            'image' => 'https://picsum.photos/seed/' . rand(1, 1000) . '/800/600',
            'is_published' => true,
        ];
    }
}
