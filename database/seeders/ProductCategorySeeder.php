<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Celana',
                'slug' => 'celana'
            ],
            [
                'name' => 'Baju',
                'slug' => 'baju'
            ]
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
