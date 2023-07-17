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

    public function agregar(Request $request)
    {
        $datosRequest = $request->all();
        $producto = new Producto;
        $producto->Nombre = $datosRequest[0];
        $producto->Precio = intval($datosRequest[1]);
        $producto->TipoMoneda = $datosRequest[2];
        $producto->Stock = intval($datosRequest[3]);
        $producto->save();
        return response()->json($producto);
    }

    public function modificar(Request $request)
    {
        $datosRequest = $request->all();
        $producto = Producto::find($datosRequest[0]);
        $producto->Nombre = $datosRequest[1];
        $producto->Precio = intval($datosRequest[2]);
        $producto->TipoMoneda = $datosRequest[3];
        $producto->Stock = intval($datosRequest[4]);
        $producto->save();
        return response()->json($request);
    }

    public function eliminar(Request $request)
    {
        $idProducto=$request->get('identificador');
        $producto = Producto::find($idProducto);
        $producto->delete();
        if ($producto) {
            return response()->json("Usuario $producto eliminado correctamente");
        } else {
            return response()->json("El usuario con el ID $idProducto no existe");
        }
    }
}