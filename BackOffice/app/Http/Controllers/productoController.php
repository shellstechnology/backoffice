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
    {{try{
        $datosRequest = $request->all();
        $producto = new Producto;
        $producto->Nombre = $datosRequest[0];
        $producto->Precio = intval($datosRequest[1]);
        $producto->TipoMoneda = $datosRequest[2];
        $producto->Stock = intval($datosRequest[3]);
        $producto->save();
        return response()->json($producto);
    }catch(\Exception $e){
        return response()->json(['error' => 'Error al agregar el producto'], 500);

    }
}
    }

    public function modificar(Request $request)
    {{
        try {
            $datosRequest = $request->all();
            Producto::where('id', $datosRequest[0])->update([
                'Nombre' => $datosRequest[1],
                'Precio' => $datosRequest[2],
                'TipoMoneda' => $datosRequest[3],
                'Stock' => $datosRequest[4],
            ]);
            return response()->json($datosRequest);
        }catch(\Exception $e){
            return response()->json(['error' => 'Error al modificar el producto'], 500);
        }
    }
    }

    public function eliminar(Request $request)
    {
        $id = $request->get('identificador'); {
            try {
                Producto::where('id', $id)->delete();
                return response()->json(['mensaje' => 'Producto eliminado correctamente']);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al eliminar el producto'], 500);
            }
        }
    }
}