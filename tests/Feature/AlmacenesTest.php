<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\almacenes;
use App\Models\lugares_entrega;
use App\Models\User;
use Tests\TestCase;

class AlmacenesTest extends TestCase
{
    public function test_agregarUnAlmacen(){
        $user = User::factory()->create();
        $response = $this->followingRedirects()->actingAs($user)->post('/Almacenes',
        [
            "accion" => "agregar",
            "idLugarEntrega" => "1",
        ]);
        $ultimoAlmacen= almacenes::latest('created_at')->first();
        $idAlmacen = $ultimoAlmacen['id'];
        $ultimaDireccion = Lugares_Entrega::latest('created_at')->first();
        $idDireccion = $ultimaDireccion['id'];
        $response->assertStatus(200);
        $this->assertDatabaseHas('almacenes', [
            'id' => $idAlmacen,
        ]);
        almacenes::withTrashed()->where('id',$idAlmacen)->forceDelete();
       }
    

       public function test_ModificarUnAlmacen(){
        $user = User::factory()->create();
        $response = $this->followingRedirects()->actingAs($user)->post('/Almacenes',
        [
            "accion" => "modificar",
            "identificador" => "42",
            "idLugarEntrega" => "1",
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('almacenes',[
            'id' => '42',

        ]);
       }



       public function test_EliminarUnAlmacen(){
        $user = User::factory()->create();
        $response = $this->followingRedirects()->actingAs($user)->post('/Almacenes',[
            "accion" => "eliminar",
            "identificador" => "5",

        ]);
        $response->assertStatus(200);
        Almacenes::withTrashed()->where("id",5)->restore();
       }



       public function test_RecuprarUnAlmacen(){
        $user = User::factory()->create();
        $response1 = $this->followingRedirects()->actingAs($user)->post('/Almacenes',[
            "accion" => "eliminar",
            "identificador" => "5",

        ]);
        $response1->assertStatus(200);
    
        $response2 = $this->followingRedirects()->actingAs($user)->post('/Almacenes',[
            "accion" => "recuperar",
            "identificador" => "5",
        ]);
      $response2->assertStatus(200);
       }

}
