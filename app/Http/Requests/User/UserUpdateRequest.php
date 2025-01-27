<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:3', 'max:200'],
            'email' => ['required', 'string', 'email', 'max:200', 'unique:' . User::class . ',email,' . $this->route('user')],
            'password' => [
                'nullable',
                'string',
                Password::min(8) // mínimo de 8 caracteres
                    ->letters() // Deve conter pelo menos uma letra
                    ->numbers() // Deve conter pelo menos um número
                    ->symbols(), // Deve conter pelo menos um símbolo
                // ->uncompromised(), // Verifica se a senha não foi vazada em um banco de dados público
                'confirmed', // Garante que password_confirmation corresponde
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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
            'image' => 'O arquivo deve ser uma imagem.',
            'mimes' => ':attribute deve ser do tipo: :values.',
            'image.max' => ':attribute não pode ter mais de :max kilobytes.',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nome',
            'email' => 'email',
            'password' => 'senha',
            'image' => 'imagem',
        ];
    }
}
