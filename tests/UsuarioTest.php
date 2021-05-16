<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UsuarioTest extends TestCase
{
    public function testCriarUsuario()
    {
        $dados = [
            'nome' => 'Usuario 1',
            'email' => 'usuario1@test.com',
            'password' => '123'
        ];

        //cadastrando o usuario:
        $this->post('/api/salvarusuario', $dados);
        $this->assertResponseOk();

        $resposta = (array) json_decode($this->response->content()); // pegando o retorno, em json, e convertendo para array
        // var_dump($resposta);
        // testando se existe a chave 'nome' na resposta obtida acima, pós cadastro:
        $this->assertArrayHasKey('nome', $resposta);
        $this->assertArrayHasKey('email', $resposta);
        $this->assertArrayHasKey('id', $resposta);
    }
}
