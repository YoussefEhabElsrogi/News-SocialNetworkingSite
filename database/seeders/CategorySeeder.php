<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Technology Category', 'Sports Category', 'Fashion Category', 'Bookes Category'];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category],
                [
                    'name' => $category,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now()->addMonth(),
                ]
            );
        }
    }
}
