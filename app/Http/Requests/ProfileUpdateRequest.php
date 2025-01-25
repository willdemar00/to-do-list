<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:200'],
            'email' => [
                'required',
                'string',
                'email',
                'max:200',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute é obrigatório.',
            'string' => ':attribute deve ser uma string.',
            'max' => ':attribute não pode ter mais de :max caracteres.',
            'email' => ':attribute deve ser um endereço de email válido.',
            'min' => ':attribute deve ter no mínimo :min caracteres',
            'unique' => ':attribute já está em uso.',
            'image' => 'O arquivo deve ser uma imagem.',
            'mimes' => ':attribute deve ser do tipo: :values.',
            'image.max' => ':attribute não pode ter mais de :max kilobytes.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nome',
            'email' => 'email',
            'image' => 'imagem',
        ];
    }
}
