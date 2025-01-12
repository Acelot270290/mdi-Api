<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginEmpresaRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta solicitação.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Define as regras de validação para o login.
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255',
            'senha' => 'required|string|min:6',
        ];
    }
}
