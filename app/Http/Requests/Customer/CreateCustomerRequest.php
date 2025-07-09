<?php

namespace App\Http\Requests\Customer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CreateCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'category_id' => [
                'required',
                Rule::exists('customer_categories', 'id')
            ],
            'last_name' => 'nullable|string|max:255',
            'nickname' => 'nullable|string|max:100',
            'identification' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('customer_personnel_information', 'identification')
            ],
            'phone' => 'nullable|string|max:20',
            'secondary_phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:customer_personnel_information,email',
            'postal_code' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:20',
            'neighborhood' => 'nullable|string|max:100',
            'complement' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:2',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nome',
            'category_id' => 'Categoria',
            'last_name' => 'Sobrenome',
            'nickname' => 'Apelido',
            'identification' => 'CPF/CNPJ',
            'phone' => 'Telefone',
            'secondary_phone' => 'Telefone secundário',
            'email' => 'E-mail',
            'postal_code' => 'CEP',
            'address' => 'Endereço',
            'number' => 'Número',
            'neighborhood' => 'Bairro',
            'complement' => 'Complemento',
            'city' => 'Cidade',
            'state' => 'Estado',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string' => 'O campo :attribute deve ser texto.',
            'min' => 'O campo :attribute deve ter no mínimo :min caracteres.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
            'email' => 'O campo :attribute deve ser um e-mail válido.',
            'unique' => 'O :attribute informado já está em uso.',
            'exists' => 'A categoria selecionada é inválida.',
            'state.max' => 'O estado deve ter 2 caracteres (UF).',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Erro de validação',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}