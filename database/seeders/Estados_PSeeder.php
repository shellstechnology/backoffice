<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Estados_PSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\estados_P::factory(1)->create([
            "id"=>"1",
            "descripcion_estado_p" => "en almacen",
        ]);
        \App\Models\estados_P::factory(1)->create([
            "id"=>"2",
            "descripcion_estado_p" => "en camino",
        ]);
        \App\Models\estados_P::factory(1)->create([
            "id"=>"3",
            "descripcion_estado_p" => "entregado",
        ]);
        \App\Models\estados_P::factory(1)->create([
            "id"=>"47",
            "descripcion_estado_p" => "estado p listar",
        ]);
        \App\Models\estados_P::factory(1)->create([
            "id"=>"42",
            "descripcion_estado_p" => "estado p Modificar",
        ]);
        \App\Models\estados_P::factory(1)->create([
            "id"=>"74",
            "descripcion_estado_p" => "estado p eliminar",
        ]);
    }
}
