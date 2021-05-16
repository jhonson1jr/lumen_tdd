<?php

use App\Models\Usuarios;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Usuarios::insert([
            [
                'nome'          => 'Usuario 1',
                'email'         => 'usuario1@test.com',
                'password'      => Hash::make('1234'),
                'api_token'     => Str::random(100),
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
