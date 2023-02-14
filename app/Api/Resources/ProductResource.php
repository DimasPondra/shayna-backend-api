<?php

namespace App\Api\Resources;

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
            'product_category_id' => $this->product_category_id,
            'file_id' => $this->file_id,
            'file_url' => $this->file->show_file
        ];
    }
}
