<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthRequest extends FormRequest
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
            'email' => 'required_without:username|email',
            'password' => 'required|string|min:6',
            'username' => 'nullable|string|min:4|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'E-mail',
            'password' => 'Senha',
            'username' => 'Usuário',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Campo Obrigatório',
            'email.required_without' => 'O campo :attribute é obrigatório quando o campo Usuário não estiver presente.',
            'email.email' => ':attribute inválido',

            'password.required' => 'Necessita de uma :attribute',

            'password.min' => 'Minimo 6 caracteres',
            'username.min' => 'Minimo 4 caracteres',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
