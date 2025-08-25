<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Teknologi', 'description' => 'Artikel tentang teknologi terbaru'],
            ['name' => 'Lifestyle', 'description' => 'Tips dan trik kehidupan sehari-hari'],
            ['name' => 'Travel', 'description' => 'Pengalaman dan tips traveling'],
            ['name' => 'Food', 'description' => 'Resep dan review makanan'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
}