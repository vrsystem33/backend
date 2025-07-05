<?php

namespace App\Http\Requests\Carrier;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CarrierRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|max:11',
            'email' => 'nullable|email',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Name',
            'phone' => 'Phone',
            'email' => 'Email',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The :attribute field is required.',
            'email.email' => 'Invalid :attribute.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 500));
    }
}
