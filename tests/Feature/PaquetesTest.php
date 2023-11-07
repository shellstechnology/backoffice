<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Caracteristicas;
use App\Models\Estados_p;
use App\Models\Lugares_Entrega;
use App\Models\Paquetes;
use App\Models\Producto;
use App\Models\User;

class PaquetesTest extends TestCase
{


    public function test_agregarUnPaquete(){
        $user = User::factory()->create();
        $response = $this->followingRedirects()->actingAs($user)->post('/paquetes',
        [
            "accion" => "agregar",
            "identificador" => "99",
            "nombrePaquete" => "inbuscable",
            "dia"=> "4",
            "mes"=> "7",
            "anio"=> "2040",
            "idLugarEntrega" =>"1",
            "estadoPaquete" => "en almacen",
            "caracteristica"=> "explosivo",
            "nombreRemitente" => "ab",
            "nombreDestinatario"=> "yo",
            "idProducto" =>"42",
            "volumen"=>"1",
            "peso"=> "1"
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('paquetes', [
            'nombre' => 'inbuscable'
        ]);
        Paquetes::withTrashed()->where('nombre','inbuscable')->forceDelete();
       }
    

       public function test_ModificarUnPaquete(){
        $user = User::factory()->create();
        $response = $this->followingRedirects()->actingAs($user)->post('/paquetes',
        [
            "accion" => "modificar",
            "identificador" => "42",
            "nombrePaquete" => "paquete a modificar",
            "dia"=> "4",
            "mes"=> "7",
            "anio"=> "2001",
            "idLugarEntrega" =>"2",
            "estadoPaquete" => "en almacen",
            "caracteristica"=> "explosivo",
            "nombreRemitente" => "shells tech la venganza del programador",
            "nombreDestinatario"=> "shells tech",
            "idProducto" =>"47",
            "volumen"=>"9.9",
            "peso"=> "9.9",
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('paquetes',[
            'id' => '42',
            'nombre' => 'paquete a modificar'
        ]);
       }


       public function test_EliminarUnPaquete(){
        $user = User::factory()->create();
        $response = $this->followingRedirects()->actingAs($user)->post('/paquetes',[
            "accion" => "eliminar",
            "identificador" => "74",
            "nombrePaquete" => "paquete a eliminar",
            "dia"=> "4",
            "mes"=> "7",
            "anio"=> "2001",
            "idLugarEntrega" =>"2",
            "estadoPaquete" => "en almacen",
            "caracteristica"=> "explosivo",
            "nombreRemitente" => "shell al cuadrado",
            "nombreDestinatario"=> "pseudoshell",
            "idProducto" =>"47",
            "volumen"=>"9.9",
            "peso"=> "9.9",
        ]);
        $response->assertStatus(200);
        Paquetes::withTrashed()->where("id",74)->restore();
       }
      
      
       public function test_RecuperarUnPaquete(){
        $user = User::factory()->create();
        $response1 = $this->followingRedirects()->actingAs($user)->post('/paquetes',[
            "accion" => "eliminar",
            "identificador" => "74",
            "nombrePaquete" => "paquete a eliminar",
            "dia"=> "4",
            "mes"=> "7",
            "anio"=> "2001",
            "idLugarEntrega" =>"2",
            "estadoPaquete" => "en almacen",
            "caracteristica"=> "explosivo",
            "nombreRemitente" => "shell al cuadrado",
            "nombreDestinatario"=> "pseudoshell",
            "idProducto" =>"47",
            "volumen"=>"9.9",
            "peso"=> "9.9",
        ]);
        $response1->assertStatus(200);
    
        $response2 = $this->followingRedirects()->actingAs($user)->post('/paquetes',[
            "accion" => "recuperar",
            "identificador" => "74",
            "nombrePaquete" => "paquete a eliminar",
            "dia"=> "4",
            "mes"=> "7",
            "anio"=> "2001",
            "idLugarEntrega" =>"2",
            "estadoPaquete" => "en almacen",
            "caracteristica"=> "explosivo",
            "nombreRemitente" => "shell al cuadrado",
            "nombreDestinatario"=> "pseudoshell",
            "idProducto" =>"47",
            "volumen"=>"9.9",
            "peso"=> "9.9",
        ]);
      $response2->assertStatus(200);
       }

}
