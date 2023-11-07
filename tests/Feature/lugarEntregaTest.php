<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Lugares_Entrega;
use App\Models\User;

class lugarEntregaTest extends TestCase
{
  
    public function test_agregarUnLugarDeEntrega(){
        $user = User::factory()->create();
     $response = $this->followingRedirects()->actingAs($user)->post('/destinos',
     [
        "accion" => "agregar",
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
        $user = User::factory()->create();
        $response = $this->followingRedirects()->actingAs($user)->post('/destinos',
        [
            "accion" => "modificar",
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
        $user = User::factory()->create();
        $response = $this->followingRedirects()->actingAs($user)->post('/destinos',[
            "accion" => "eliminar",
            "identificador" => "5",
            "direccion" => "almacen 74 eliminar",
            "latitud" => "74",
            "longitud" => "74"
        ]);
        $response->assertStatus(200);
        Lugares_Entrega::withTrashed()->where("latitud",74)->restore();
       }
    

       public function test_RecuprarUnLugarDeEntrega(){
        $user = User::factory()->create();
        $response1 = $this->followingRedirects()->actingAs($user)->post('/destinos',[
            "accion" => "eliminar",
            "identificador" => "5",
            "direccion" => "almacen 74 eliminar",
            "latitud" => "74",
            "longitud" => "74"
        ]);
        $response1->assertStatus(200);
    
        $response2 = $this->followingRedirects()->actingAs($user)->post('/destinos',[
            "accion" => "recuperar",
            "identificador" => "5",
            "direccion" => "almacen 74 eliminar",
            "latitud" => "74",
            "longitud" => "74"
        ]);
      $response2->assertStatus(200);
       }
    }
    

