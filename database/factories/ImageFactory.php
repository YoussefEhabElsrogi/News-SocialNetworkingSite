<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
*/
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paths = ['test/news1.jpg', 'test/news2.jpeg', 'test/news3.jpg', 'test/news4.jpg', 'test/news5.jpeg', 'test/news6.jpeg', 'test/news7.jpeg'];

        return [
            'path' => fake()->randomElement($paths),
            'created_at' => now(),
            'updated_at' => now()->addMonth(),
        ];
    }
}
