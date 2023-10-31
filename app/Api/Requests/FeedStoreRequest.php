<?php

namespace App\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'url' => 'required|string|url',
            'file_id' => 'required|exists:files,id'
        ];
    }
}
