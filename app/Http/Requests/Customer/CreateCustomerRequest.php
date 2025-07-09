<?php

namespace App\Http\Requests\Customer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:3',
            'email' => 'nullable|email',
            'cpf'   => 'nullable|string|unique:customer_personnel_information,identification',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nome',
            'email' => 'E-mail',
            'cpf' => 'CPF',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Necessita de um :attribute.',
            'name.min' => ':attribute muito pequeno.',
            'email.email' => 'Formato de :attribute inválido.',
            'cpf.unique' => ':attribute já cadastrado.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 500));
    }
}
