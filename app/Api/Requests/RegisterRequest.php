<?php

namespace App\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:6|max:12',
            'phone_number' => 'required|string|max:13',
            'address' => 'required|string|max:255'
        ];
    }
}
