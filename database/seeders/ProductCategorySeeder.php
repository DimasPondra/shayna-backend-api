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
                'name' => 'Shirt',
                'slug' => 'shirt'
            ],
            [
                'name' => 'Sweater',
                'slug' => 'sweater'
            ],
            [
                'name' => 'Dress',
                'slug' => 'dress'
            ],
            [
                'name' => 'Suit',
                'slug' => 'suit'
            ],
            [
                'name' => 'Jacket',
                'slug' => 'jacket'
            ]
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
