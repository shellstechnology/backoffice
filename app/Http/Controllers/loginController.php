<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Http;
use Session;
use Illuminate\Support\Facades\Auth;


class loginController extends Controller
{
   // public function iniciarSesion(Request $request){
    //    $response=Http::post('http://127.0.0.1:8003/api/v1/login', [
    //        'name' => $request->input('name'),
     //       'password' => $request->input('password'),
     //   ]);
    //    dd($response->json());
   // }
   
   public function iniciarSesion(Request $request){
    $credentials = $request->only('name', 'password');
    if (Auth::attempt($credentials)) 
        return redirect("/");
    return redirect("/login")->with("failed",true);
}

public function Logout(Request $request){
    Auth::logout();
    return redirect("/login")->with("logout",true);
}
}
