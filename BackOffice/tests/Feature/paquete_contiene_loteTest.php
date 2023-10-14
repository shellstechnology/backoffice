<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Almacenes;
use App\Models\Lotes;
use App\Models\Paquetes;
use App\Models\Paquete_Contiene_Lote;

class paquete_contiene_loteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_agregarUnPaqueteAUnLote(){

        $response = $this->followingRedirects()->post('/paquetes-lote',
        [
            "accion" => "agregar",
            "identificador" => "42",
            "idPaquete" => "104",
            "idLote"=> "100",
            "idAlmacen"=>"42"
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('paquete_contiene_lote', [
            'id_paquete' => '104',
            'id_lote' => '100',
        ]);
        Paquete_Contiene_Lote::withTrashed()->where('id_paquete','104')->where('id_lote','100')->forceDelete();
       }
    
       public function test_ModificarUnPaqueteEnUnlote(){

        $response = $this->followingRedirects()->post('/paquetes-lote',
        [
            "accion" => "modificar",
            "identificador" => "42",
            "idPaquete" => "42",
            "idLote"=> "42",
            "idAlmacen"=>"42"
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('paquete_contiene_lote',[
            "id_paquete" => "42",
            "id_lote"=> "42",
        ]);
       }

       public function test_EliminarUnPaqueteEnUnlote(){
        $response = $this->followingRedirects()->post('/paquetes-lote',[
            "accion" => "eliminar",
            "identificador" => "74",
            "idPaquete" => "74",
            "idLote"=> "74",
            "idAlmacen"=>"74"
        ]);
        $response->assertStatus(200);
        Paquete_Contiene_Lote::withTrashed()->where("id_paquete",74)->restore();
       }


       public function test_RecuprarUnPaqueteEnUnLote(){
        $response1 = $this->followingRedirects()->post('/paquetes-lote',[
            "accion" => "eliminar",
            "identificador" => "74",
            "idPaquete" => "74",
            "idLote"=> "74",
            "idAlmacen"=>"74"
        ]);
        $response1->assertStatus(200);
    
        $response2 = $this->followingRedirects()->post('/paquetes-lote',[
            "accion" => "recuperar",
            "identificador" => "74",
            "idPaquete" => "74",
            "idLote"=> "74",
            "idAlmacen"=>"74"
        ]);
      $response2->assertStatus(200);
       }

}
