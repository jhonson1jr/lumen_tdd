<?php

use App\Models\Usuarios;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UsuarioTest extends TestCase
{
    // Removendo os cadastros realizados após o retorno positivo dos testes:
    use DatabaseTransactions; // O que for cadastrado, será removido automaticamente (rollback)

    // Teste de cadastro de novo usuario:
    public function testCriarUsuario()
    {
        $dados = [
            'nome' => 'Usuario 2',
            'email' => 'usuario2@test.com',
            'password' => '123'
        ];

        //cadastrando o usuario:
        $this->post('/api/salvarusuario', $dados);
        $this->assertResponseOk();

        $resposta = (array) json_decode($this->response->content()); // pegando o retorno, em json, e convertendo para array
        
        // testando se os campns existem na resposta obtida acima, pós cadastro:
        $this->assertArrayHasKey('nome', $resposta);
        $this->assertArrayHasKey('email', $resposta);
        $this->assertArrayHasKey('id', $resposta);
    }

    // Teste de select de usuário:
    public function testDetalhesUsuario()
    {
        // Buscando o primeiro usuario que existir no banco
        $usuario = Usuarios::first();

        //obtendo o usuario:
        $this->get('/api/detalhesusuario/' . $usuario->id);
        $this->assertResponseOk();

        $resposta = (array) json_decode($this->response->content()); // pegando o retorno, em json, e convertendo para array

        // testando se os campns existem na resposta obtida acima:
        $this->assertArrayHasKey('nome', $resposta);
        $this->assertArrayHasKey('email', $resposta);
        $this->assertArrayHasKey('id', $resposta);
    }
}
