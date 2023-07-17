<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class productoController extends Controller
{
    public function cargarDatos()
    {
        $datoProducto = Producto::all();
        return response()->json($datoProducto);
    }

    public function agregar(Request $request)  {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|integer',
            'tipoMoneda' => 'required|string|max:255',
            'stock' => 'required|integer',
        ]);
        $datosRequest= $request->all();
        $producto=new Producto;
        $producto->Id=intval($datosRequest[0]);
        $producto->Nombre=$datosRequest[1];
        $producto->Precio=intval($datosRequest[2]);
        $producto->TipoMoneda=$datosRequest[3];
        $producto->Stock=intval($datosRequest[4]);
        Producto::insert($producto);
        return response()->json($producto);
    }

    public function modificar(){

    }

    public function eliminar(){

    }
}
