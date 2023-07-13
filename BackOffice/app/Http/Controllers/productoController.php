<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class productoController extends Controller
{
    public function action()
    {
        $datos = Producto::all();
        return view('vistaBackOffice', compact('datos'));
    }
}
