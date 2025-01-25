<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PasswordUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required'],
            'new_password' => [
                'required',
                'string',
                Password::min(8) // mínimo de 8 caracteres
                    ->letters() // Deve conter pelo menos uma letra
                    ->numbers() // Deve conter pelo menos um número
                    ->symbols(), // Deve conter pelo menos um símbolo
                    // ->uncompromised(), // Verifica se a senha não foi vazada em um banco de dados público
                'confirmed', // Garante que password_confirmation corresponde
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute é obrigatório',
            'password.letters' => ':attribute deve conter pelo menos uma letra.',
            'password.numbers' => ':attribute deve conter pelo menos um número.',
            'password.symbols' => ':attribute deve conter pelo menos um símbolo.',
            'confirmed' => 'A confirmação de :attribute não corresponde',
            'min' => ':attribute deve ter no mínimo :min caracteres',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'current_password' => 'senha atual',
            'new_password' => 'nova senha',
        ];
    }
}
