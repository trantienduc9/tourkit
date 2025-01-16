<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        // Seeder generates 10,000 posts in 20 random categories
        Post::factory(10000)->create()->each(function ($post) use ($categories) {
            $post->categories()->attach(
                $categories->random(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}
