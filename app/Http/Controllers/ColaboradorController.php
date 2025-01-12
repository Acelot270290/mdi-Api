<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadColaboradorRequest;
use App\Repositories\ColaboradorRepository;
use Illuminate\Support\Facades\Log;

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
}
