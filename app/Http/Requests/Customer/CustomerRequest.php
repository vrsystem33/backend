<?php

namespace App\Http\Requests\Customer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'phone' => 'required|min:10|max:11|unique:clients,phone'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nome',
            'phone' => 'Tel.\Cel.',
        ];
    }

    public function messages()
    {
        return [
            'name.min' => ':attribute muito pequeno.',
            'name.max' => ':attribute muito grande.',
            'name.required' => 'Necessita de um :attribute.',
            'phone.unique' => 'Número de :attribute já cadastrado!.',
            'phone.min' => 'Número de :attribute inválido!',
            'phone.max' => 'Número de :attribute inválido!',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 500));
    }
}
