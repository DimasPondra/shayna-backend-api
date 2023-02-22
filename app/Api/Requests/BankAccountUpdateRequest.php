<?php

namespace App\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankAccountUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'bank_id' => 'required|exists:banks,id'
        ];
    }
}
