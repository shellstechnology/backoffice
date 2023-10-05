<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Caracteristicas;
use App\Models\Estados_p;
use App\Models\Lugares_Entrega;
use App\Models\Paquetes;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PaqueteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Paquetes::factory(1)->create([
            "id" => "10",
            "nombre" => "tuercas",
            "volumen_l" => "9.9",
            "peso_kg" => "9.9", 
            "id_estado_p" => "1",
            "id_caracteristica_paquete" => "4",
            "id_producto" => "7",
            "id_lugar_entrega" => "2",
            "nombre_destinatario" => "a",
            "nombre_remitente" => "b"
        ]);
        \App\Models\Paquetes::factory(1)->create([
            "id" => "47",
            "nombre" => "proyecto2023",
            "volumen_l" => "9.9",
            "peso_kg" => "9.9", 
            "id_estado_p" => "1",
            "id_caracteristica_paquete" => "4",
            "id_producto" => "47",
            "id_lugar_entrega" => "2",
            "nombre_destinatario" => "shells tech",
            "nombre_remitente" => "shells tech tambien"
        ]);
        \App\Models\Paquetes::factory(1)->create([
            "id" => "42",
            "nombre" => "paquete a modificar",
            "volumen_l" => "9.9",
            "peso_kg" => "9.9", 
            "id_estado_p" => "1",
            "id_caracteristica_paquete" => "4",
            "id_producto" => "47",
            "id_lugar_entrega" => "2",
            "nombre_destinatario" => "shells tech",
            "nombre_remitente" => "shells tech la venganza del programador"
        ]);
        \App\Models\Paquetes::factory(1)->create([
            "id" => "74",
            "nombre" => "paquete a eliminar",
            "volumen_l" => "9.9",
            "peso_kg" => "9.9", 
            "id_estado_p" => "1",
            "id_caracteristica_paquete" => "4",
            "id_producto" => "47",
            "id_lugar_entrega" => "2",
            "nombre_destinatario" => "pseudoshell",
            "nombre_remitente" => "shell al cuadrado"
        ]);
    }
}
