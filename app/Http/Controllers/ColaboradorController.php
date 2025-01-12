<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadColaboradorRequest;
use App\Models\Colaborador;
use App\Repositories\ColaboradorRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ColaboradorController extends Controller
{
    protected $repository;

    public function __construct(ColaboradorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function uploadCSV(UploadColaboradorRequest $request)
    {
        try {
            // Recupera o arquivo e o ID da empresa autenticada
            $file = $request->file('file');
            $empresaId = auth()->user()->id;

            $result = $this->repository->handleUpload($file, $empresaId);

            return response()->json(['message' => $result['message']], 202);
        } catch (\Exception $e) {
            Log::error('Erro no upload do arquivo CSV: ' . $e->getMessage());
            return response()->json(['error' => 'Erro interno no servidor.'], 500);
        }
    }


    public function filter(Request $request)
    {
        try {
            $empresaId = auth()->user()->id;
            $filters = $request->only(['email', 'nome', 'cargo']);

            $colaboradores = $this->repository->filterColaboradores($filters, $empresaId);

            return response()->json($colaboradores, 200);
        } catch (\Exception $e) {
            Log::error('Erro ao filtrar colaboradores: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao filtrar colaboradores.'], 500);
        }
    }
}
