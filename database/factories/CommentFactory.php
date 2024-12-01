<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
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
            'comment' => $this->faker->paragraph,
            'ip_address' => $this->faker->ipv4,
            'status' => $this->faker->boolean,
            'user_id' => User::inRandomOrder()->first()->id,
            'post_id' => Post::inRandomOrder()->first()->id,
            'created_at' => $date,
            'updated_at' => $date->addMonth(),
        ];
    }
}
