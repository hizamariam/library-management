<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(10),
            'author' => $this->faker->name(),
            'likes_count' => $this->faker->numberBetween(5, 60),
            'comments_count' => $this->faker->numberBetween(5, 60),
        ];
    }
}
