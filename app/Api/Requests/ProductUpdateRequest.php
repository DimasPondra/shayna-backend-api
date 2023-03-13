<?php

namespace App\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:products,name,'. $this->product->id,
            'description' => 'required|string',
            'price' => 'required|integer',
            'product_category_id' => 'required|exists:product_categories,id',
            'file_id' => 'required|exists:files,id'
        ];
    }
}
