<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class productoController extends Controller
{
    public function action()
    {
        $datoProducto = producto::all();
        return back()->with('datoProducto', $datoProducto);
    }

    public function agregar(Request $request){
        dd($request);

        return response()->json(['mensaje' => 'Datos recibidos correctamente']);
    }

    public function modificar(){

    }

    public function eliminar(){

    }
}
