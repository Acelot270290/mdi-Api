<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadColaboradorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Permite a validação
    }

    public function rules(): array
    {
        return [
            'file' => 'required|mimes:csv,txt|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'O arquivo é obrigatório.',
            'file.mimes' => 'O arquivo deve ser do tipo CSV ou TXT.',
            'file.max' => 'O tamanho máximo do arquivo é de 2MB.',
        ];
    }
}
