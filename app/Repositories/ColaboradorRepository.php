<?php
namespace App\Repositories;

use App\Jobs\ProcessColaboradorCsv;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ColaboradorRepository
{
    public function handleUpload($file, $empresaId)
    {
        try {
            // Log: Início do upload
            Log::info('Iniciando o upload do arquivo CSV.');

            // Define o caminho no bucket
            $filePath = 'uploads/' . uniqid() . '_' . $file->getClientOriginalName();

            // Salvar o arquivo no MinIO usando Storage::disk('s3')
            Log::info('Salvando o arquivo no MinIO no caminho: ' . $filePath);
            $stored = Storage::disk('s3')->put($filePath, file_get_contents($file));

            if (!$stored) {
                Log::error('Falha ao salvar o arquivo no MinIO.');
                throw new \Exception('Falha ao salvar o arquivo no MinIO.');
            }

            // Dispatch Job para processamento
            Log::info('Enviando o job de processamento para a fila com empresa ID: ' . $empresaId);
            ProcessColaboradorCsv::dispatch($filePath, $empresaId);

            return ['success' => true, 'message' => 'Upload iniciado com sucesso.'];
        } catch (\Exception $e) {
            Log::error('Erro ao processar o upload: ' . $e->getMessage());
            throw $e;
        }
    }
}
