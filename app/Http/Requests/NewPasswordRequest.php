<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class NewPasswordRequest extends FormRequest
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
            'email' => ['required', 'string', 'email'],
            'password' => [
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
            'unique' => ':attribute já está em uso',
            'password.uncompromised' => 'A senha fornecida foi encontrada em um banco de dados público e não pode ser usada.',
            'password.letters' => ':attribute deve conter pelo menos uma letra.',
            'password.numbers' => ':attribute deve conter pelo menos um número.',
            'password.symbols' => ':attribute deve conter pelo menos um símbolo.',
            'confirmed' => 'A confirmação de :attribute não corresponde',
            'min' => ':attribute deve ter no mínimo :min caracteres',
            'max' => ':attribute deve ter no máximo :max caracteres',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'email',
            'password' => 'senha',
        ];
        
    }
}
