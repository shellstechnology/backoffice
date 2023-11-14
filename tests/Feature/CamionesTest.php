<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Camion_Lleva_Lote;
use App\Models\Camiones;
use App\Models\Chofer_Conduce_Camion;
use App\Models\Choferes;
use App\Models\Estados_c;
use App\Models\Marcas;
use App\Models\Modelos;
use App\Models\Usuarios;
use App\Models\User;

class CamionesTest extends TestCase
{
    public function test_agregarUnCamion(){
        $user = User::factory()->create();
        $response = $this->followingRedirects()->actingAs($user)->post('/camiones',
        [
            "accion" => "agregar",
            "identificador" => "abcd",
            "matricula" => "abcd",
            "estadoCamion"=>"estado c listar",
            "marcaModeloCamion"=>"marca listar:modelo listar",
            "chofer"=>"choferprueba",
            "volumen"=>"10",
            "peso"=> "10"
        ]);
        $response->assertStatus(200);
        $this->actingAs($user)->assertDatabaseHas('camiones', [
            'matricula' => 'abcd',
        ]);
        Chofer_Conduce_Camion::withTrashed()->where('matricula_camion','abcd')->forceDelete();
        Camiones::withTrashed()->where('matricula','abcd')->forceDelete();
       }


       public function test_ModificarUnCamion(){
        $user = User::factory()->create();
        $response = $this->followingRedirects()->actingAs($user)->post('/camiones',
        [
            "accion" => "modificar",
            "identificador" => "a42a",
            "matricula" => "a42a",
            "estadoCamion"=>"estados c modificar",
            "marcaModeloCamion"=>"marca modificar:modelo update",
            "chofer"=>"usuario a modificar",
            "volumen"=>"99",
            "peso"=> "99"
        ]);
        $response->assertStatus(200);
        $this->actingAs($user)->assertDatabaseHas('camiones',[
            "matricula"=> "a42a"
        ]);
       }
    

       public function test_EliminarUnCamion(){
        $user = User::factory()->create();
        $response = $this->followingRedirects()->actingAs($user)->post('/camiones',[
            "accion" => "eliminar",
            "identificador" => "a47a",
            "matricula" => "a74a",
            "estadoCamion"=>"estados c eliminar",
            "marcaModeloCamion"=>"marca eliminar:modelo eliminar",
            "chofer"=>"usuario a eliminar",
            "volumen"=>"99",
            "peso"=> "99"
        ]);
        $response->assertStatus(200);
        Camiones::withTrashed()->where("matricula",'a74a')->restore();
       }
    

       public function test_RecuprarUnCamion(){
        $user = User::factory()->create();
        $response1 = $this->followingRedirects()->actingAs($user)->post('/camiones',[
            "accion" => "eliminar",
            "identificador" => "a47a",
            "matricula" => "a74a",
            "estadoCamion"=>"estados c eliminar",
            "marcaModeloCamion"=>"marca eliminar:modelo eliminar",
            "chofer"=>"usuario a eliminar",
            "volumen"=>"99",
            "peso"=> "99"
        ]);
        $response1->assertStatus(200);
    
        $response2 = $this->followingRedirects()->actingAs($user)->post('/camiones',[
            "accion" => "recuperar",
            "identificador" => "a47a",
            "matricula" => "a74a",
            "estadoCamion"=>"estados c eliminar",
            "marcaModeloCamion"=>"marca eliminar:modelo eliminar",
            "chofer"=>"usuario a eliminar",
            "volumen"=>"99",
            "peso"=> "99"
        ]);
      $response2->assertStatus(200);
       }
}
