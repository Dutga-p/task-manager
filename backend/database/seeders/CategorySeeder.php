<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Trabajo', 'color' => '#3B82F6', 'icon' => '💼'],
            ['name' => 'Personal', 'color' => '#10B981', 'icon' => '🏠'],
            ['name' => 'Urgente', 'color' => '#EF4444', 'icon' => '🚨'],
            ['name' => 'Estudio', 'color' => '#8B5CF6', 'icon' => '📚'],
            ['name' => 'Compras', 'color' => '#F59E0B', 'icon' => '🛒'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
