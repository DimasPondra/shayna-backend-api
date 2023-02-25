<?php

namespace App\Api\Resources;

use App\Helpers\RequestHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'format_price' => 'Rp ' . $this->format_price,

            'category' => $this->when(
                RequestHelper::doesQueryParamsHasValue($request->query('include'), 'category'),
                (new ProductCategoryResource($this->productCategory))
            ),

            'file' => $this->when(
                RequestHelper::doesQueryParamsHasValue($request->query('include'), 'file'),
                (new FileResource($this->file))
            )
        ];
    }
}
