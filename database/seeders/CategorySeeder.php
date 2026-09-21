<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Dress',      'slug' => 'dress',      'icon' => '👗', 'sort_order' => 1],
            ['name' => 'Blouse',     'slug' => 'blouse',     'icon' => '👚', 'sort_order' => 2],
            ['name' => 'Outer',      'slug' => 'outer',      'icon' => '🧥', 'sort_order' => 3],
            ['name' => 'Rok',        'slug' => 'rok',        'icon' => '👘', 'sort_order' => 4],
            ['name' => 'Celana',     'slug' => 'celana',     'icon' => '👖', 'sort_order' => 5],
            ['name' => 'Aksesoris',  'slug' => 'aksesoris',  'icon' => '💍', 'sort_order' => 6],
        ];

        foreach ($categories as $cat) {
            Category::create(array_merge($cat, ['is_active' => true]));
        }
    }
}
