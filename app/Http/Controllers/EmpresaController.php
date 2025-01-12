<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterEmpresaRequest;
use App\Http\Requests\LoginEmpresaRequest;
use App\Models\Empresa;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class EmpresaController extends Controller
{
    /**
     * Registra uma nova empresa.
     */
    public function register(RegisterEmpresaRequest $request)
    {
        // Criação da empresa
        $empresa = Empresa::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'senha' => Hash::make($request->senha),
        ]);

        return response()->json(['message' => 'Empresa registrada com sucesso!'], 201);
    }

    /**
     * Autentica uma empresa e gera o token JWT.
     */
    public function login(LoginEmpresaRequest $request)
    {
        // Credenciais do login
        $credentials = $request->only('email', 'senha');

        // Verificar as credenciais
        $empresa = Empresa::where('email', $credentials['email'])->first();

        if (!$empresa || !Hash::check($credentials['senha'], $empresa->senha)) {
            return response()->json(['error' => 'Credenciais inválidas'], 401);
        }

        // Gera o token JWT
        $token = JWTAuth::fromUser($empresa);

        return response()->json([
            'message' => 'Login realizado com sucesso!',
            'token' => $token,
        ]);
    }

    /**
     * Retorna os dados da empresa autenticada.
     */
    public function me()
    {
        $empresa = auth()->user();

        return response()->json($empresa);
    }

    /**
     * Faz logout da empresa.
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Logout realizado com sucesso!']);
    }
}
