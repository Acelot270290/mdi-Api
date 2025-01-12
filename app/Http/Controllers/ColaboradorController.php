<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessColaboradorCsv;
use Illuminate\Support\Facades\Storage;


class ColaboradorController extends Controller
{
    public function uploadCSV(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        // Salvar o arquivo no MinIO
        $filePath = $request->file('file')->store('uploads', 's3');

        dd($filePath);

        // Dispatch Job para processamento
        ProcessColaboradorCsv::dispatch($filePath, auth()->user()->id);

        return response()->json(['message' => 'Upload iniciado com sucesso.'], 202);
    }
}
