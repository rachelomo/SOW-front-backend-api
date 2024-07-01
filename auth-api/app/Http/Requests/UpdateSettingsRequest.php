<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->user()->id,
            'phoneNumber' => 'nullable|string|max:20',
            'companyName' => 'nullable|string|max:255',
            'streetAdress' => 'nullable|string|max:255',
            'zipCode' => 'nullable|string|max:10',
            'profileImage' => 'nullable|image|max:5120',
        ];
    }
}

