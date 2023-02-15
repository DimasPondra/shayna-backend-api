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
        $productCategories = $this->model
            ->when(!empty($params['search']['name']), function ($query) use ($params) {
                return $query->where('name', 'LIKE', '%' . $params['search']['name'] . '%');
            });

        if (!empty($params['paginate'])) {
            return $productCategories->paginate($params['paginate']);
        }

        return $productCategories->get();
    }

    public function store(ProductCategory $productCategory)
    {
        $productCategory->save();

        return $productCategory;
    }
}
