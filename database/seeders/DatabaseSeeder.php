<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MonedasSeeder::class);
        $this->call(ProductoSeeder::class); 
        $this->call(Descripcion_Caracteristica_PaqueteSeeder::class);
        $this->call(Estados_PSeeder::class);
        $this->call(lugarEntregaSeeder::class);
        $this->call(PaqueteSeeder::class);
        $this->call(LotesSeeder::class);
        $this->call(AlmacenesSeeder::class);
        $this->call(PaqueteContieneLoteSeeder::class);
        $this->call(MarcasSeeder::class);
        $this->call(ModelosSeeder::class);
        $this->call(Estados_CSeeder::class);
        $this->call(CamionesSeeder::class);
        $this->call(camion_lleva_loteSeeder::class);
    
            \App\Models\User::factory(1)->create([
                "name" => "usuario",
                "email" => "usuario@usuario"
            ]);
            \App\Models\User::factory(1)->create([
                "id" => "10",
                "name"=>"toreto",
            ]);
            \App\Models\User::factory(1)->create([
                "id" => "20",
                "name"=>"choferpreba",
            ]);
            \App\Models\User::factory(1)->create([
                "id" => "47",
                "name"=>"usuario a listar",
            ]);
            \App\Models\User::factory(1)->create([
                "id" => "42",
                "name"=>"usuario a modificar",
            ]);
            \App\Models\User::factory(1)->create([
                "id" => "74",
                "name"=>"usuario a eliminar",
            ]);
            \App\Models\User::factory(1)->create([
                "name"=>"admin",
            ]);
            \App\Models\User::factory(1)->create([
                "name"=>"chofer",
            ]);
            \App\Models\User::factory(1)->create([
                "name"=>"almacenero",
            ]);
        

        $this->call(telefonos_usuariosSeeder::class);
        $this->call(ChoferesSeeder::class);
        $this->call(AdministradoresSeeder::class);
        $this->call(ClientesSeeder::class);
        $this->call(AlmacenerosSeeder::class);
        $this->call(chofer_conduce_camionSeeder::class);
    }
}
