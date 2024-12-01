<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '123123123',
            'remember_token' => Str::random(10),
            'username' => $this->faker->unique()->userName(),
            'image' => $this->faker->imageUrl(),
            'status' => $this->faker->randomElement([1, 0]),
            'country' => $this->faker->country(),
            'city' => $this->faker->city(),
            'street' => $this->faker->streetAddress(),
            'phone' => '01' . $this->faker->randomElement([0, 1, 2, 5]) . $this->faker->numberBetween(10000000, 99999999),
            'created_at' => $date,
            'updated_at' => $date->addMonth(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
