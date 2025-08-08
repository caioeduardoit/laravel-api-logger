<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Log;
use App\Models\ApiClient;

class LogApiTest extends TestCase
{
    use RefreshDatabase;
    
    protected $token = 'token-test'; // Token fixo que será usado no teste

    protected function setUp(): void
    {
        parent::setUp();

        $client = ApiClient::create([
            'name' => 'Cliente de Teste',
            'api_token' => hash('sha256', $this->token)
        ]);

        // dump($client);
    }

    public function test_create_log()
    {
        $payload = [
            'ip' => '192.168.0.1',
            'method' => 'POST',
            'route' => '/api/test',
            'payload' => [
                'user' => 'caioeduardo',
                'action' => 'login',
                'info' => 'this is a test 123'
            ]
        ];

        // Faz o request POST para o endpoint /api/logs
        // $response = $this->postJson('/api/logs', $payload);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->postJson('/api/logs', $payload);

        // Verifica se a resposta tem status 201 (created)
        $response->assertStatus(201);

        // Verifica se o banco de dados contém o registro criado
        $this->assertDatabaseHas('logs', [
            'ip' => '192.168.0.1',
            'method' => 'POST',
            'route' => '/api/test',
        ]);
    }
}
