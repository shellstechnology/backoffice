<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Lotes;
use App\Models\User;
use Tests\TestCase;

class LotesTest extends TestCase
{


    public function test_agregarUnLote(){
        $user = User::factory()->create();
        $response = $this->followingRedirects()->actingAs($user)->post('/lotes',
        [
            "accion" => "agregar",
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
        $user = User::factory()->create();
        $response = $this->followingRedirects()->actingAs($user)->post('/lotes',[
            "accion" => "eliminar",
            "identificador" => "74"
        ]);
        $response->assertStatus(200);
       Lotes::withTrashed()->where("id",74)->restore();
       }


       public function test_RecuprarUnLote(){
        $user = User::factory()->create();
        $response1 = $this->followingRedirects()->actingAs($user)->post('/lotes',[
            "accion" => "eliminar",
            "identificador" => "74"
        ]);
        $response1->assertStatus(200);
    
        $response2 = $this->followingRedirects()->actingAs($user)->post('/lotes',[
            "accion" => "recuperar",
            "identificador" => "74"
        ]);
      $response2->assertStatus(200);
       }

}
