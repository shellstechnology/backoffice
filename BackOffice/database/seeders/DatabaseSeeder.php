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
        // \App\Models\User::factory(10)->create();
        $this->call(ProductoSeeder::class); 
        $this->call(lugarEntregaSeeder::class);
        $this->call(PaqueteSeeder::class);
        $this->call(LotesSeeder::class);
        $this->call(AlmacenesSeeder::class);
        $this->call(PaqueteContieneLoteSeeder::class);
    }
}
