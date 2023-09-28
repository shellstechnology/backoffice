<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Telefonos_Usuarios;

class TelefonosTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
   public function test_agregarUnTelefono(){

    $response = $this->followingRedirects()->post('/telefonos',
    [
        "cbxAgregar" => "on",
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

    $response = $this->followingRedirects()->post('/telefonos',
    [
        "cbxModificar" => "on",
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
    $response = $this->followingRedirects()->post('/telefonos',[
        "cbxEliminar" => "on",
        "datoUsuario" => "74",
        "identificadorId" => "74",
        "identificadorTelefono" =>"tel del",
        "telefono" => "tel del"
    ]);
    $response->assertStatus(200);
    Telefonos_Usuarios::withTrashed()->where("id_usuarios",74)->restore();
   }

   public function test_RecuprarUnTelefono(){
    $response1 = $this->followingRedirects()->post('/telefonos',[
        "cbxEliminar" => "on",
        "datoUsuario" => "74",
        "identificadorId" => "74",
        "identificadorTelefono" =>"tel del",
        "telefono" => "tel del"
    ]);
    $response1->assertStatus(200);

    $response2 = $this->followingRedirects()->post('/telefonos',[
        "cbxRecuperar" => "on",
        "datoUsuario" => "74",
        "identificadorId" => "74",
        "identificadorTelefono" =>"tel del",
        "telefono" => "tel del"
    ]);
  $response2->assertStatus(200);
   }
}
