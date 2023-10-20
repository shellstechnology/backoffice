<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Clientes::factory(1)->create([
            "id_usuarios"=>"47",
        ]);
        \App\Models\Clientes::factory(1)->create([
            "id_usuarios"=>"42",
        ]);
        \App\Models\Clientes::factory(1)->create([
            "id_usuarios"=>"74",
        ]);
    }
}
