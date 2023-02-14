<?php

namespace App\Repositories;

use App\Models\ProductCategory;

class ProductCategoryRepository
{
    private $model;

    public function __construct(ProductCategory $model)
    {
        $this->model = $model;
    }

    public function get($params = [])
    {
        $productCategories = $this->model;

        return $productCategories->get();
    }

    public function store(ProductCategory $productCategory)
    {
        $productCategory->save();

        return $productCategory;
    }
}
