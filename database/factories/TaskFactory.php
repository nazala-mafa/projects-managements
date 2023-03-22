<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_assign' => fake()->randomElement([2, 3]),
            'name' => fake()->sentence(),
            'description' => fake()->sentence(12),
            'deadline' => fake()->date('Y-m-d', now()->addDays(30)),
            'image' => url('/assets/images/default-image.jpg'),
        ];
    }
}