<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Commerce & Vente',
            'Comptabilité & Finance',
            'IT & Informatique',
            'Ressources Humaines',
            'Marketing & Communication',
            'Ingénierie technique',
            'Santé & Médical',
            'Transport & Logistique'
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate([
                'slug' => Str::slug($category)
            ], [
                'name' => $category
            ]);
        }
    }
}
