<?php

namespace App\Http\Requests\Customer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $uuid = $this->route('id');
        return [
            'name' => 'sometimes|required|string|min:3',
            'email' => 'nullable|email|unique:customer_personnel_information,email,'.$uuid.',uuid',
            'cpf'   => 'nullable|string|unique:customer_personnel_information,identification,'.$uuid.',uuid',
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
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 500));
    }
}
