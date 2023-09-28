<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Lugares_Entrega;

class lugarEntregaTest extends TestCase
{
  
    public function test_agregarUnLugarDeEntrega(){
 
     $response = $this->followingRedirects()->post('/destinos',
     [
         "cbxAgregar" => "on",
         "identificador" => "6",
         "direccion" => "destino agregado",
         "latitud" => "40",
         "longitud" => "40"
     ]);
     $response->assertStatus(200);
     $this->assertDatabaseHas('lugares_entrega', [
         'direccion' => 'destino agregado',
         'latitud' => '40',
     ]);
     Lugares_Entrega::withTrashed()->where('direccion','destino agregado')->forceDelete();
    }

    public function test_ModificarUnLugarDeEntrega(){

        $response = $this->followingRedirects()->post('/destinos',
        [
            "cbxModificar" => "on",
            "identificador" => "4",
            "direccion" => "almacen 42 modificar",
            "latitud" => "42",
            "longitud" => "42"
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('lugares_entrega',[
            "direccion" => "almacen 42 modificar",
            "longitud" => "42"
        ]);

       }
       public function test_EliminarUnLugarDeEntrega(){
        $response = $this->followingRedirects()->post('/destinos',[
            "cbxEliminar" => "on",
            "identificador" => "5",
            "direccion" => "almacen 74 eliminar",
            "latitud" => "74",
            "longitud" => "74"
        ]);
        $response->assertStatus(200);
        Lugares_Entrega::withTrashed()->where("latitud",74)->restore();
       }
    

       public function test_RecuprarUnLugarDeEntrega(){
        $response1 = $this->followingRedirects()->post('/destinos',[
            "cbxEliminar" => "on",
            "identificador" => "5",
            "direccion" => "almacen 74 eliminar",
            "latitud" => "74",
            "longitud" => "74"
        ]);
        $response1->assertStatus(200);
    
        $response2 = $this->followingRedirects()->post('/destinos',[
            "cbxRecuperar" => "on",
            "identificador" => "5",
            "direccion" => "almacen 74 eliminar",
            "latitud" => "74",
            "longitud" => "74"
        ]);
      $response2->assertStatus(200);
       }
    }
    

