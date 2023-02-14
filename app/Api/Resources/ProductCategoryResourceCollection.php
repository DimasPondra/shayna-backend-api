<?php

namespace App\Api\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCategoryResourceCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($productCategory) use ($request) {

                return [
                    'id' => $productCategory->id,
                    'name' => $productCategory->name
                ];
            })
        ];
    }
}
