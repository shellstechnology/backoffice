<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Administradores;
use App\Models\Almaceneros;
use App\Models\Choferes;
use App\Models\Clientes;
use App\Models\Telefonos_Usuarios;
use App\Models\User;

class UsuariosTest extends TestCase
{
 

    public function test_agregarUnUsuario(){
        $user = User::factory()->create();
        $response = $this->followingRedirects()->actingAs($user)->post('/usuarios',
        [
            "accion" => "agregar",
            "identificador" => "444",
            "nombre" => "multiusos",
            "contrasenia" =>"4",
            "mail" => "mail123@mail",
            "usuarioAdministrador"=> "on",

        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'name' => 'multiusos',
        ]);
        
        $usuario =  User::where('name', 'multiusos')->first();
        $usuarioId = $usuario->getkey();
        Administradores::withTrashed()->where('id_usuarios', $usuarioId)->forceDelete();
        Choferes::withTrashed()->where('id_usuarios', $usuarioId)->forceDelete();
        Clientes::withTrashed()->where('id_usuarios', $usuarioId)->forceDelete();
        Almaceneros::withTrashed()->where('id_usuarios', $usuarioId)->forceDelete();
        User::withTrashed()->where('name','multiusos')->where('email', 'mail123@mail')->forceDelete();
       }

       public function test_ModificarUnUsuario(){
        $user = User::factory()->create();
        $response = $this->followingRedirects()->actingAs($user)->post('/usuarios',
        [
            "accion" => "modificar",
            "identificador" => "42",
            "nombre" => "usuario a modificar",
            "contrasenia" =>"bb",
            "mail" => "modificar@mail",
            "usuarioAdministrador"=> "on",
            "usuarioChofer" => "on",
            "usuarioCliente"=> "on",
            "usuarioAlmacenero" =>"on",

     
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users',[
            'id' => '42',
            'name' => 'usuario a modificar'
        ]);
       }


       
       public function test_EliminarUnUsuario(){
        $user = User::factory()->create();
        $response = $this->followingRedirects()->actingAs($user)->post('/usuarios',[
            "accion" => "eliminar",
            "identificador" => "74",
            "nombre" => "usuario a eliminar",
            "contrasenia" =>"cc",
            "mail" => "eliminar@mail",
            "usuarioAdministrador"=> "on",
            "usuarioChofer" => "on",
            "usuarioCliente"=> "on",
            "usuarioAlmacenero" =>"on",
        ]);
        $response->assertStatus(200);
        User::withTrashed()->where("id",74)->restore();
       }

       public function test_RecuperarUnUsuario(){
        $user = User::factory()->create();
        $response1 = $this->followingRedirects()->actingAs($user)->post('/usuarios',[
            "accion" => "eliminar",
            "identificador" => "74",
            "nombre" => "usuario a eliminar",
            "contrasenia" =>"cc",
            "mail" => "eliminar@mail",
            "usuarioAdministrador"=> "on",
            "usuarioChofer" => "on",
            "usuarioCliente"=> "on",
            "usuarioAlmacenero" =>"on",
        ]);
        $response1->assertStatus(200);
    
        $response2 = $this->followingRedirects()->actingAs($user)->post('/usuarios',[
            "accion" => "recuperar",
            "identificador" => "74",
            "nombre" => "usuario a eliminar",
            "contrasenia" =>"cc",
            "mail" => "eliminar@mail",
            "usuarioAdministrador"=> "on",
            "usuarioChofer" => "on",
            "usuarioCliente"=> "on",
            "usuarioAlmacenero" =>"on",
        ]);
      $response2->assertStatus(200);
       }

}
