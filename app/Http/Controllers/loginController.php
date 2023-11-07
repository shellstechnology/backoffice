<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Http;
use Session;


class loginController extends Controller
{
    public function iniciarSesion(Request $request){
        $response=Http::post('http://127.0.0.1:8003/api/v1/login', [
            'name' => $request->input('name'),
            'password' => $request->input('password'),
        ]);
        dd($response->json());
    }
}
