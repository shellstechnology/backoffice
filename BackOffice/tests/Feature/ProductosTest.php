<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Moneda;
use App\Models\Producto;
use App\Http\Controllers\Controller;

class ProductosTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     public function test_agregarUnProducto(){

        $response = $this->followingRedirects()->post('/productos',
        [
            "cbxAgregar" => "on",
            "identificador" => "444",
            "nombre" => "productonuevo",
            "stock" => "96",
            "precio" => "96",
            "tipoMoneda" =>"pesos uruguayos"
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('productos', [
            'nombre' => 'productonuevo',
            'precio' => '96',
        ]);
        Producto::withTrashed()->where('nombre','productonuevo')->where('precio','96')->forceDelete();
       }
    
       public function test_ModificarUnProducto(){
    
        $response = $this->followingRedirects()->post('/productos',
        [
            "cbxModificar" => "on",
            "identificador" => "42",
            "nombre" => "proyecto hector",
            "stock" => "1",
            "precio" => "9999",
            "tipoMoneda"=> "pesos uruguayos"
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('productos',[
            'id' => '42',
            'nombre' => 'proyecto hector'
        ]);
       }
    
       public function test_EliminarUnProducto(){
        $response = $this->followingRedirects()->post('/productos',[
            "cbxEliminar" => "on",
            "identificador" => "74",
            "nombre"=> "proyecto 2",
            "stock" => "1",
            "precio" => "9999",
            "tipoMoneda" => "pesos uruguayos"
        ]);
        $response->assertStatus(200);
        Producto::withTrashed()->where("id",74)->restore();
       }
    
       public function test_RecuperarUnProductos(){
        $response1 = $this->followingRedirects()->post('/productos',[
            "cbxEliminar" => "on",
            "identificador" => "74",
           "nombre" => "proyecto 2",
           "stock" => "1",
           "precio" => "9999",
           "tipoMoneda" => "pesos uruguayos"
        ]);
        $response1->assertStatus(200);
    
        $response2 = $this->followingRedirects()->post('/productos',[
            "cbxRecuperar" => "on",
            "identificador" => "74",
            "nombre" => "proyecto 2",
            "stock" => "1",
            "precio" => "9999",
            "tipoMoneda" => "pesos uruguayos"
        ]);
      $response2->assertStatus(200);
       }

      
}
