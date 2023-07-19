<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class productoController extends Controller
{
    public function cargarDatos()
    {
        $datoProducto = Producto::withTrashed()->get();
        return response()->json($datoProducto);
    }

    public function agregar(Request $request)
    {{try{
        $datosRequest = $request->all();
        $reglas=[
            'nombre' => 'required|string|max:20',
            'precio' => 'required|integer|min:1|max:9999999',
            'tipoMoneda' =>'required|string|max:3',
            'stock' => 'required|integer|min:0|max:9999999',
        ];
        $validador = Validator::make(['nombre' => $datosRequest[0],
                                      'precio' => $datosRequest[1],
                                      'tipoMoneda' => $datosRequest[2],
                                      'stock' => $datosRequest[3]], $reglas);

        if ($validador->fails()) {
            $errores = $validador->getMessageBag();
            return response()->json(['error:' =>$errores], 422);
        }
        $producto = new Producto;
        $producto->Nombre = $datosRequest[0];
        $producto->Precio = intval($datosRequest[1]);
        $producto->TipoMoneda = $datosRequest[2];
        $producto->Stock = intval($datosRequest[3]);
        $producto->save();
        return response()->json($producto);
    }catch(\Exception $e){
        return response()->json(['error' => 'Error al ingresar el paquete'], 500);

    }
}
    }

    public function modificar(Request $request)
    {{
        try {
            $datosRequest = $request->all();
            $reglas=[
                'nombre' => 'required|string|max:20',
                'precio' => 'required|integer|min:1|max:9999999',
                'tipoMoneda' =>'required|string|max:3',
                'stock' => 'required|integer|min:0|max:9999999',
            ];
            $validador = Validator::make(['nombre' => $datosRequest[1],
                                          'precio' => $datosRequest[2],
                                          'tipoMoneda' => $datosRequest[3],
                                          'stock' => $datosRequest[4]], $reglas);
            if ($validador->fails()) {
                $errores = $validador->getMessageBag();
                return response()->json(['error:' =>$errores], 422);
            }
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