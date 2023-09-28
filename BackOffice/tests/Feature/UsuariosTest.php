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
use App\Models\Usuarios;
use App\Models\Mail_Usuarios;

class UsuariosTest extends TestCase
{
 

    public function test_agregarUnUsuario(){

        $response = $this->followingRedirects()->post('/usuarios',
        [
            "cbxAgregar" => "on",
            "identificador" => "444",
            "nombre" => "multiusos",
            "contrasenia" =>"4",
            "mail" => "mail@mail",
            "usuarioAdministrador"=> "on",
            "usuarioChofer" => "on",
            "usuarioCliente"=> "on",
            "usuarioAlmacenero" =>"on",

        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('usuarios', [
            'nombre_de_usuario' => 'multiusos',
            'contrasenia' => '4',
        ]);
        
        $usuario =  Usuarios::where('contrasenia', '4')->first();
        $usuarioId = $usuario->getkey();
        Mail_Usuarios::withTrashed()->where('id_usuarios',$usuarioId)->forceDelete();
        Administradores::withTrashed()->where('id_usuarios', $usuarioId)->forceDelete();
        Choferes::withTrashed()->where('id_usuarios', $usuarioId)->forceDelete();
        Clientes::withTrashed()->where('id_usuarios', $usuarioId)->forceDelete();
        Almaceneros::withTrashed()->where('id_usuarios', $usuarioId)->forceDelete();
        Usuarios::withTrashed()->where('nombre_de_usuario','multiusos')->where('contrasenia', '4')->forceDelete();
       }

       public function test_ModificarUnUsuario(){
    
        $response = $this->followingRedirects()->post('/usuarios',
        [
            "cbxModificar" => "on",
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
        $this->assertDatabaseHas('usuarios',[
            'id' => '42',
            'nombre_de_usuario' => 'usuario a modificar'
        ]);
       }


       
       public function test_EliminarUnUsuario(){
        $response = $this->followingRedirects()->post('/usuarios',[
            "cbxEliminar" => "on",
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
        Usuarios::withTrashed()->where("id",74)->restore();
       }

       public function test_RecuperarUnUsuario(){
        $response1 = $this->followingRedirects()->post('/usuarios',[
            "cbxEliminar" => "on",
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
    
        $response2 = $this->followingRedirects()->post('/usuarios',[
            "cbxRecuperar" => "on",
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
