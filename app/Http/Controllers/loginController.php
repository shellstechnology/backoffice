<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Http;
use Session;
use Illuminate\Support\Facades\Auth;


class loginController extends Controller
{   
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
