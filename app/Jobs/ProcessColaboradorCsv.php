<?php

namespace App\Jobs;

use App\Models\Colaborador;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use Throwable;

class ProcessColaboradorCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $empresaId;

    /**
     * Cria uma nova instância do Job.
     *
     * @param string $filePath Caminho do arquivo CSV.
     * @param int $empresaId ID da empresa.
     */
    public function __construct($filePath, $empresaId)
    {
        $this->filePath = $filePath;
        $this->empresaId = $empresaId;
    }

    /**
     * Processa o arquivo CSV.
     */
    public function handle()
    {
        try {
            // Ler o arquivo do armazenamento
            $file = Storage::get($this->filePath);
            $csv = Reader::createFromString($file);
            $csv->setHeaderOffset(0); // Define a primeira linha como cabeçalho

            foreach ($csv as $record) {
                // Atualiza ou cria o colaborador
                Colaborador::updateOrCreate(
                    ['email' => $record['email']], // Condição de correspondência
                    [
                        'empresa_id' => $this->empresaId,
                        'nome' => $record['nome'],
                        'cargo' => $record['cargo'],
                        'data_admissao' => $record['data_admissao'],
                    ]
                );
            }

            // Exclui o arquivo após o processamento
            Storage::delete($this->filePath);

            Log::info('Arquivo CSV processado com sucesso para a empresa ID: ' . $this->empresaId);
        } catch (Throwable $exception) {
            $this->failed($exception);
        }
    }

    /**
     * Trata falhas no processamento do Job.
     *
     * @param Throwable $exception
     */
    public function failed(Throwable $exception)
    {
        Log::error('Erro ao processar o arquivo CSV: ' . $exception->getMessage());
    }
}
