<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
        \App\Models\usuarios::factory(1)->create([
            "id" => "10",
            "name"=>"toreto",
            "email"=>"toreto@familia.com",
            "password" => Hash::make("ee"),
        ]);
        \App\Models\usuarios::factory(1)->create([
            "id" => "20",
            "name"=>"choferpreba",
            "email"=>"mail@prueba.com",
            "password" => Hash::make("dd"),
        ]);
        \App\Models\usuarios::factory(1)->create([
            "id" => "47",
            "name"=>"usuario a listar",
            "email"=> "usuario@listar.com",
            "password" => Hash::make("aa"),
        ]);
        \App\Models\usuarios::factory(1)->create([
            "id" => "42",
            "name"=>"usuario a modificar",
            "email"=> "usuario@modificar.com",
            "password" => Hash::make("bb"),
        ]);
        \App\Models\usuarios::factory(1)->create([
            "id" => "74",
            "name"=>"usuario a eliminar",
            "email"=> "usuario@eliminar.com",
            "password" => Hash::make("cc"),
        ]);
    }
}
