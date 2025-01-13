<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Multimedia>
 */
class MultimediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(['image', 'video']),
            'path' => fake()->imageUrl(),
            'alt_text' => fake()->word(),
            'caption' => fake()->sentence(),
            'article_id' => Article::all()->random()->id,

        ];
    }
}
