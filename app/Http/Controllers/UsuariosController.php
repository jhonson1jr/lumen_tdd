<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    
    public function salvarUsuario(Request $request)
    {
        // validando os dados de entrada:
        $this->validate( $request, [
            'nome' => 'required|max:255',
            'email' => 'required|unique:usuarios|max:255',
            'password' => 'required|max:255'
            
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

}
