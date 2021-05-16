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
            'nome' => 'Usuario 2 ' . uniqid() . rand(0, 100),
            'email' => 'usuario2'. uniqid() . rand(0, 100) . '@test.com',
            'password' => '123',
            'password_confirmation' => '123' // confirmação de senha
        ];

        //cadastrando o usuario:
        $this->post('/api/salvarusuario', $dados);
        // print_r($this->response->content());
        $this->assertResponseOk();
        $resposta = (array) json_decode($this->response->content()); // pegando o retorno, em json, e convertendo para array
        
        // testando se os campns existem na resposta obtida acima, pós cadastro:
        $this->assertArrayHasKey('nome', $resposta);
        $this->assertArrayHasKey('email', $resposta);
        $this->assertArrayHasKey('id', $resposta);

        // testando se realmente salvou:
        $this->seeInDatabase('usuarios', [
            'nome' => $dados['nome'],
            'email' => $dados['email']
        ]);
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
    
    // Teste de alteração de usuário sem atualização de senha
    public function testAlterarUsuarioSemInformarSenha()
    {
        // Buscando o primeiro usuario que existir no banco para alterar:
        $usuario = Usuarios::first();

        $dados = [
            'nome' => 'Usuario 10 ' . uniqid() . rand(0, 100),
            'email' => 'usuario10'. uniqid() . rand(0, 100) . '@test.com'
        ];

        //atualizando o usuario:
        $this->put('/api/atualizarusuario/' . $usuario->id, $dados);
        $this->assertResponseOk();

        $resposta = (array) json_decode($this->response->content()); // pegando o retorno, em json, e convertendo para array

        // testando se os campns existem na resposta obtida acima:
        $this->assertArrayHasKey('nome', $resposta);
        $this->assertArrayHasKey('email', $resposta);
        $this->assertArrayHasKey('id', $resposta);

        // testando se os dados atuais (sobrescritos) estão realmente diferente dos anteriores:
        $this->notSeeInDatabase('usuarios', [
            'id' => $usuario->id, // esse vai permanecer inalterado, diferente dos demais campos
            'nome' => $usuario->nome,
            'email' => $usuario->email
        ]);
    }
    
    // Teste de alteração de usuário com atualização de senha:
    public function testAlterarUsuarioComSenha()
    {
        // Buscando o primeiro usuario que existir no banco para alterar:
        $usuario = Usuarios::first();

        $dados = [
            'nome' => 'Usuario 10 ' . uniqid() . rand(0, 100),
            'email' => 'usuario10'. uniqid() . rand(0, 100) . '@test.com',
            'password' => '1234',
            'password_confirmation' => '1234' // confirmação de senha
        ];

        //atualizando o usuario:
        $this->put('/api/atualizarusuario/' . $usuario->id, $dados);
        $this->assertResponseOk();

        $resposta = (array) json_decode($this->response->content()); // pegando o retorno, em json, e convertendo para array

        // testando se os campns existem na resposta obtida acima:
        $this->assertArrayHasKey('nome', $resposta);
        $this->assertArrayHasKey('email', $resposta);
        $this->assertArrayHasKey('id', $resposta);

        // testando se os dados atuais (sobrescritos) estão realmente diferente dos anteriores:
        $this->notSeeInDatabase('usuarios', [
            'id' => $usuario->id, // esse vai permanecer inalterado, diferente dos demais campos
            'nome' => $usuario->nome,
            'email' => $usuario->email
        ]);
    }
    
    // Teste de select de todos os usuários:
    public function testListarUsuarios()
    {
        //obtendo o usuario:
        $this->get('/api/listarusuarios/');
        $this->assertResponseOk();

        // testando se no retorno contem os a estrutura da tabela usuarios
        $this->seeJsonStructure([
            '*' =>[
                'id',
                'nome',
                'email'
            ]
        ]);
    }

    // Teste de remoção de usuário:
    public function testDeletarUsuario()
    {
        // Buscando o primeiro usuario que existir no banco para remover:
        $usuario = Usuarios::first();

        //removendo o usuario:
        $this->delete('/api/deletarusuario/' . $usuario->id);
        $this->assertResponseOk();

        // validando o retorno:
        $this->assertEquals('Removido com sucesso', $this->response->content());
    }
}
