<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Faker\Factory as Faker;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create 20 records with random data for the 'title' field
        foreach (range(1, 20) as $index) {
            Category::create([
                'title' => $faker->word,  // Generate a random word for the 'title' field
            ]);
        }
    }
}
