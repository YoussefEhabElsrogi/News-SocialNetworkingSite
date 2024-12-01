<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get the current year
        $year = now()->year;

        // Get a random month (1 to 12)
        $month = $this->faker->numberBetween(1, 12);

        // Choose a random day based on the month
        $day = rand(1, Carbon::create($year, $month, 1)->daysInMonth);

        // Generate a random date
        $date = Carbon::create($year, $month, $day, rand(0, 23), rand(0, 59), rand(0, 59));

        return [
            'title' => $this->faker->sentence(5),
            'desc' => $this->faker->paragraph(6),
            'comment_able' => $this->faker->boolean,
            'status' => $this->faker->boolean,
            'number_of_views' => rand(0, 300),
            'user_id' => User::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'created_at' => $date,
            'updated_at' => $date->addMonth(),
        ];
    }
}
