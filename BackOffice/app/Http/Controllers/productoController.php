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
    { {
            try {
                $datosRequest = $request->all();
                $reglas = [
                    'Nombre' => 'required|string|max:20',
                    'Precio' => 'required|integer|min:1|max:9999999',
                    'TipoMoneda' => 'required|string|max:3',
                    'Stock' => 'required|integer|min:0|max:9999999',
                ];
                $validador = Validator::make([
                    'Nombre' => $datosRequest[0],
                    'Precio' => $datosRequest[1],
                    'TipoMoneda' => $datosRequest[2],
                    'Stock' => $datosRequest[3]
                ], $reglas);

                if ($validador->fails()) {
                    $errores = $validador->getMessageBag();
                    return response()->json(['error:' => $errores], 422);
                }
                $producto = new Producto;
                $producto->Nombre = $datosRequest[0];
                $producto->Precio = $datosRequest[1];
                $producto->TipoMoneda = $datosRequest[2];
                $producto->Stock = $datosRequest[3];
                $producto->save();
                return response()->json("SI");
            } catch (\Exception $e) {
                return response()->json(['Error al ingresar el paquete'], 500);

            }
        }
    }

    public function modificar(Request $request)
    { {
            try {
                $datosRequest = $request->all();
                $reglas = [
                    'nombre' => 'required|string|max:20',
                    'precio' => 'required|integer|min:1|max:9999999',
                    'tipoMoneda' => 'required|string|max:3',
                    'stock' => 'required|integer|min:0|max:9999999',
                ];
                $validador = Validator::make([
                    'nombre' => $datosRequest[1],
                    'precio' => $datosRequest[2],
                    'tipoMoneda' => $datosRequest[3],
                    'stock' => $datosRequest[4]
                ], $reglas);
                if ($validador->fails()) {
                    $errores = $validador->getMessageBag();
                    return response()->json(['error:' => $errores], 422);
                }
                Producto::where('id', $datosRequest[0])->update([
                    'Nombre' => $datosRequest[1],
                    'Precio' => $datosRequest[2],
                    'TipoMoneda' => $datosRequest[3],
                    'Stock' => $datosRequest[4],
                ]);
                return response()->json("Producto modificado correctamente");
            } catch (\Exception $e) {
                return response()->json(['Error al modificar el producto'], 500);
            }
        }
    }

    public function eliminar(Request $request)
    {
        $id = $request->get('identificador'); {
            try {
                Producto::where('id', $id)->delete();
                return response()->json(['Producto eliminado correctamente']);
            } catch (\Exception $e) {
                return response()->json(['Error al eliminar el producto'], 500);
            }
        }
    }

    public function recuperar(Request $request)
    {
        $id = $request->get('identificador');
        $producto = Producto::withTrashed()->find($id);
        if ($producto) {
            try {
                Producto::where('id', $id)->restore();
                return response()->json(['El producto a sido restaurado']);
            } catch (\Exception $e) {
                return response()->json(['Error al restaurar el producto'], 500);
            }
        } else {
            return response()->json(['El producto no puede ser recuperado porque ya existe']);
        }
    }

}