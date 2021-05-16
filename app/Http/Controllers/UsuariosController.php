<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    public function salvarUsuario(Request $request)
    {
        // validando os dados de entrada:
        $this->validate( $request, [
            'nome' => 'required|max:255',
            'email' => 'required|unique:usuarios|max:255',
            'password' => 'required|confirmed|max:255'            
        ]);
        
        // Cadastrando novo usuario:
        $usuario = new Usuarios();
        $usuario->nome = $request->nome;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->save();
        return $usuario;
    }
       
    public function detalhesUsuario($id_usuario)
    {
        // Buscando o usuario na base:
        $usuario = Usuarios::find($id_usuario);

        return $usuario;
    }

    public function atualizarUsuario(Request $request, $id_usuario)
    {
        // validando os dados de entrada sem a senha (opcional): 
        $validacao = [
            'nome' => 'required|max:255',
            'email' => 'required|unique:usuarios|max:255'
        ];

        if (isset($request->password)) { // se a senha foi enviada, incluimos na validação acima
            $validacao['password'] = 'required|confirmed|max:255';
        }

        $this->validate( $request, $validacao);

        // Buscando o usuario na base:
        $usuario = Usuarios::find($id_usuario);
        $usuario->nome = $request->nome;
        $usuario->email = $request->email;
        if (isset($request->password)) { // se a senha foi enviada, alteramos
            $usuario->password = Hash::make($request->password);
        }
        $usuario->update();
        return $usuario;
    }
       
    public function listarUsuarios()
    {
        // Pegando todos os usuarios na base:
        $usuarios = Usuarios::all();

        return $usuarios;
    }
    
    public function deletarUsuario($id_usuario)
    {
        // removendo o usuario da base:
        if (Usuarios::destroy($id_usuario)) { // se funcionou
            return new Response('Removido com sucesso', 200);
        }else{ // caso falhe
            return new Response('Erro ao remover', 401);
        }
    }
}
