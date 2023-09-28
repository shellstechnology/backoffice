<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Camion_Lleva_Lote;

class CamionLlevaLoteTest extends TestCase
{
    public function test_agregarUnCamionAUnLote(){

        $response = $this->followingRedirects()->post('/camion-lote',
        [
            "cbxAgregar" => "on",
            "identificador" => "20",
            "idCamion" => "a20a",
            "idLote"=>"20"
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('camion_lleva_lote', [
            "matricula" => "a20a",
            "id_lote"=>"20"
        ]);
        Camion_Lleva_Lote::withTrashed()->where('matricula','a20a')->forceDelete();
       }

       public function test_ModificarUnCamionEnLote(){

        $response = $this->followingRedirects()->post('/camion-lote',
        [
            "cbxModificar" => "on",
            "identificador" => "42",
            "idCamion" => "a42a",
            "idLote"=>"42"
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('camion_lleva_lote',[
            "matricula"=> "a42a"
        ]);
       }

       
       public function test_EliminarUnCamionEnLote(){
        $response = $this->followingRedirects()->post('/camion-lote',[
            "cbxEliminar" => "on",
            "identificador" => "47",
            "idCamion" => "a47a",
            "idLote"=>"47"
        ]);
        $response->assertStatus(200);
        Camion_Lleva_Lote::withTrashed()->where("matricula",'a74a')->restore();
       }
    

       public function test_RecuprarUnLoteEnCamion(){
        $response1 = $this->followingRedirects()->post('/camion-lote',[
            "cbxEliminar" => "on",
            "identificador" => "47",
            "idCamion" => "a47a",
            "idLote"=>"47"
        ]);
        $response1->assertStatus(200);
    
        $response2 = $this->followingRedirects()->post('/camion-lote',[
            "cbxEliminar" => "on",
            "identificador" => "47",
            "idCamion" => "a47a",
            "idLote"=>"47"
        ]);
      $response2->assertStatus(200);
       }

}
