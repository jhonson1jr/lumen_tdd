<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/api/salvarusuario', 'UsuariosController@salvarUsuario');

$router->get('/api/detalhesusuario/{id_usuario}', 'UsuariosController@detalhesUsuario');

$router->put('/api/atualizarusuario/{id_usuario}', 'UsuariosController@atualizarUsuario');

$router->get('/api/listarusuarios', 'UsuariosController@listarUsuarios');

$router->delete('/api/deletarusuario/{id_usuario}', 'UsuariosController@deletarUsuario');

// para gerarmos uma chave para a aplicação:
$router->get('/gerarchave', function() {
    return 'APP_KEY=base64:'. base64_encode(\Illuminate\Support\Str::random(32));
});