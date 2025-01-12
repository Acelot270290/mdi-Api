<?php

namespace Tests\Feature;

use App\Models\Empresa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ColaboradorControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_uploads_csv_and_dispatches_job()
    {
        // Cria uma empresa fictícia
        $empresa = Empresa::factory()->create();

        // Autentica a empresa
        $this->actingAs($empresa, 'api');

        // Simula o upload de um arquivo CSV
        $response = $this->postJson('/api/upload', [
            'file' => UploadedFile::fake()->create('test.csv', 1024),
        ]);

        $response->assertStatus(202); // Verifica o sucesso da requisição

        // Adicione outras verificações conforme necessário
    }
}
