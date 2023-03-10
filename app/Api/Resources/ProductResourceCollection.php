<?php

namespace App\Api\Resources;

use App\Helpers\RequestHelper;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductResourceCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $data = [];
        $data = $this->collection->transform(function ($product) use ($request) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => 'Rp '. $product->format_price,

                'category' => $this->when(
                    RequestHelper::doesQueryParamsHasValue($request->query('include'), 'category'),
                    (new ProductCategoryResource($product->productCategory))
                ),

                'file' => $this->when(
                    RequestHelper::doesQueryParamsHasValue($request->query('include'), 'file'),
                    (new FileResource($product->file))
                )
            ];
        });

        return $data;
    }
}
