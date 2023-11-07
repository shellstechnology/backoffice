<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Telefonos_Usuarios;
use App\Models\User;

class TelefonosTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
   public function test_agregarUnTelefono(){
    $user = User::factory()->create();
    $response = $this->followingRedirects()->actingAs($user)->post('/telefonos',
    [
        "accion" => "agregar",
        "datoUsuario" => "42",
        "telefono" => "telnuevo"
    ]);
    $response->assertStatus(200);
    $this->assertDatabaseHas('telefonos_usuarios', [
        'id_usuarios' => '42',
        'telefono' => 'telnuevo',
    ]);
    Telefonos_Usuarios::withTrashed()->where('id_usuarios','42')->where('telefono','telnuevo')->forceDelete();
   }

   public function test_ModificarUnTelefono(){
    $user = User::factory()->create();
    $response = $this->followingRedirects()->actingAs($user)->post('/telefonos',
    [
        "accion" => "modificar",
        "identificadorId" => "42",
        "identificadorTelefono" =>"tel mod",
        "datoUsuario" => "42",
        "telefono" => "tel mod"
    ]);
    $response->assertStatus(200);
    $this->assertDatabaseHas('telefonos_usuarios',[
        'id_usuarios' => '42',
        'telefono' => 'tel mod'
    ]);
   }

   public function test_EliminarUnTelefono(){
    $user = User::factory()->create();
    $response = $this->followingRedirects()->actingAs($user)->post('/telefonos',[
        "accion" => "eliminar",
        "datoUsuario" => "74",
        "identificadorId" => "74",
        "identificadorTelefono" =>"tel del",
        "telefono" => "tel del"
    ]);
    $response->assertStatus(200);
    Telefonos_Usuarios::withTrashed()->where("id_usuarios",74)->restore();
   }

   public function test_RecuprarUnTelefono(){
    $user = User::factory()->create();
    $response1 = $this->followingRedirects()->actingAs($user)->post('/telefonos',[
        "accion" => "eliminar",
        "datoUsuario" => "74",
        "identificadorId" => "74",
        "identificadorTelefono" =>"tel del",
        "telefono" => "tel del"
    ]);
    $response1->assertStatus(200);

    $response2 = $this->followingRedirects()->actingAs($user)->post('/telefonos',[
        "accion" => "recuperar",
        "datoUsuario" => "74",
        "identificadorId" => "74",
        "identificadorTelefono" =>"tel del",
        "telefono" => "tel del"
    ]);
  $response2->assertStatus(200);
   }
}
