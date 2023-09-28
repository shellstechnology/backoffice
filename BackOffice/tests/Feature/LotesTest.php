<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Lotes;
use Tests\TestCase;

class LotesTest extends TestCase
{


    public function test_agregarUnLote(){

        $response = $this->followingRedirects()->post('/lotes',
        [
            "cbxAgregar" => "on",
            "identificador" => "101",

        ]);
        $response->assertStatus(200);
        $ultimoLote = Lotes::latest('created_at')->first();
        $idLote = $ultimoLote['id'];
        $this->assertDatabaseHas('lotes', [
            'id' => $idLote,

        ]);
        
       Lotes::withTrashed()->where('id',$idLote)->forceDelete();
       }

       public function test_EliminarUnLote(){
        $response = $this->followingRedirects()->post('/lotes',[
            "cbxEliminar" => "on",
            "identificador" => "74"
        ]);
        $response->assertStatus(200);
       Lotes::withTrashed()->where("id",74)->restore();
       }


       public function test_RecuprarUnLote(){
        $response1 = $this->followingRedirects()->post('/lotes',[
            "cbxEliminar" => "on",
            "identificador" => "74"
        ]);
        $response1->assertStatus(200);
    
        $response2 = $this->followingRedirects()->post('/lotes',[
            "cbxRecuperar" => "on",
            "identificador" => "74"
        ]);
      $response2->assertStatus(200);
       }

}
