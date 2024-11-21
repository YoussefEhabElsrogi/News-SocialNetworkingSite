<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'youssef@gmail.com'],
            ['name' => 'Youssef Elsrogi', 'email_verified_at' => now(), 'username' => 'Youssef@username', 'phone' => '01124684262',  'email' => 'youssef@gmail.com', 'password' => '123123123']
        );

        User::updateOrCreate(
            ['email' => 'moamen@gmail.com'],
            ['name' => 'Moamen Elngar', 'email_verified_at' => now(), 'username' => 'Moamen@username',  'phone' => '01124684263', 'email' => 'moamen@gmail.com', 'password' => '123123123']
        );

        User::factory()->count(10)->create();
    }
}
