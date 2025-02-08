<?php

namespace App\Http\Requests\Subscription;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreSubscriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'company_id' => 'required|exists:companies,uuid',
            'plan' => 'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'company_id' => 'Identificador da Empresa',
            'plan'       => 'Plano',
        ];
    }

    public function messages()
    {
        return [
            'company_id.required' => 'Está faltando o :attribute.',
            'plan.required'       => 'Está faltando qual o :attribute.',

            'company_id.exists' => 'O :attribute não está cadastrado!.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 500));
    }
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        if ($this->has('plan')) {
            $this->merge([
                'plan' => strtolower($this->input('plan')),
            ]);
        }
    }
}
