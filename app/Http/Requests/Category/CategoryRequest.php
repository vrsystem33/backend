<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryRequest extends FormRequest
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
            'category' => 'required|string|min:3|max:255',
            'subcategory' => 'required|min:3|max:255|unique:categorias,subcategoria'
        ];
    }

    public function attributes()
    {
        return [
            'category' => 'Categoria',
            'subcategory' => 'Subcategoria',
        ];
    }

    public function messages()
    {
        return [
            'category.min' => ':attribute muito pequeno.',
            'category.max' => ':attribute muito grande.',
            'category.required' => 'Necessita de uma :attribute.',
            'subcategory.unique' => 'Número de :attribute já cadastrado!.',
            'subcategory.min' => 'Número de :attribute inválido!',
            'subcategory.max' => 'Número de :attribute inválido!',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 500));
    }
}
