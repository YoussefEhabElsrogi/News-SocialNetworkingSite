<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::updateOrCreate(['email' => 'admin@gmail.com'], [
            'name' => 'Youssef Elsrogi',
            'username' => 'Youssef@username',
            'email' => 'admin@gmail.com',
            'remember_token' => Hash::make('123123123'),
            'password' => '123123123',
            'role_id' => 1
        ]);
    }
}
