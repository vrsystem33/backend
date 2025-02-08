<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
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
            'name'        => 'required|string|max:500',
            'description' => 'nullable|max:500',
            'barcode'     => 'nullable|max:500',
            'reference'   => 'nullable|max:500',
            'unit'        => 'required|string',
            'category_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name'            => 'Nome',
            'description'     => 'Descrição',
            'barcode'         => 'Código do Produto',
            'reference'       => 'Referência',
            'unit'            => 'Unidade',
            'category_id'     => 'Categoria do Produto',
        ];
    }

    public function messages()
    {
        return [
            'name.max'          => ':attribute muito grande, maximo 500 caracteres.',
            'description.max'   => ':attribute muito grande, maximo 500 caracteres.',
            'barcode.max'       => ':attribute muito grande, maximo 500 caracteres.',
            'reference.max'     => ':attribute muito grande,  maximo 500 caracteres.',

            'name.required'         => 'Está faltando o :attribute.',
            'unit.required'         => 'Está faltando a :attribute.',
            'category_id.required'  => 'Está faltando a :attribute.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 500));
    }
}
