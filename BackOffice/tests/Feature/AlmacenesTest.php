<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Almacenes;
use App\Models\Lugares_Entrega;
use Tests\TestCase;

class AlmacenesTest extends TestCase
{
    public function test_agregarUnAlmacen(){

        $response = $this->followingRedirects()->post('/Almacenes',
        [
            "cbxAgregar" => "on",
            "identificador" => "50",
            "direccion" => "nuevoalmacen",
            "latitud"=> "20",
            "longitud"=>"20"
        ]);
        $ultimoAlmacen= Almacenes::latest('created_at')->first();
        $idAlmacen = $ultimoAlmacen['id'];
        $ultimaDireccion = Lugares_Entrega::latest('created_at')->first();
        $idDireccion = $ultimaDireccion['id'];
        $response->assertStatus(200);
        $this->assertDatabaseHas('almacenes', [
            'id' => $idAlmacen,
        ]);
        Almacenes::withTrashed()->where('id',$idAlmacen)->forceDelete();
        Lugares_Entrega::withTrashed()->where('id',$idDireccion)->forceDelete();
       }
    

       public function test_ModificarUnAlmacen(){

        $response = $this->followingRedirects()->post('/Almacenes',
        [
            "cbxModificar" => "on",
            "identificador" => "42",
            "direccion" => "nuevoalmacen",
            "latitud"=> "47",
            "longitud"=>"47"
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('almacenes',[
            'id' => '42',

        ]);
       }



       public function test_EliminarUnAlmacen(){
        $response = $this->followingRedirects()->post('/Almacenes',[
            "cbxEliminar" => "on",
            "identificador" => "5",

        ]);
        $response->assertStatus(200);
        Almacenes::withTrashed()->where("id",5)->restore();
       }



       public function test_RecuprarUnAlmacen(){
        $response1 = $this->followingRedirects()->post('/Almacenes',[
            "cbxEliminar" => "on",
            "identificador" => "5",

        ]);
        $response1->assertStatus(200);
    
        $response2 = $this->followingRedirects()->post('/Almacenes',[
            "cbxRecuperar" => "on",
            "identificador" => "5",
        ]);
      $response2->assertStatus(200);
       }

}