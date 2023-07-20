<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class almacenController extends Controller
{
    public function cargarDatos()
    {
        $datoAlmacen = Almacen::withTrashed()->get();
        return response()->json($datoAlmacen);
    }

    public function agregar(Request $request)
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
                    'nombre' => $datosRequest[0],
                    'precio' => $datosRequest[1],
                    'tipoMoneda' => $datosRequest[2],
                    'stock' => $datosRequest[3]
                ], $reglas);

                if ($validador->fails()) {
                    $errores = $validador->getMessageBag();
                    return response()->json(['error:' => $errores], 422);
                }
                Almacen::save([
                    'Nombre' => $datosRequest[0],
                    'Precio' => $datosRequest[1],
                    'TipoMoneda' => $datosRequest[2],
                    'Stock' => $datosRequest[3],
                ]);
                return response()->json("Almacen agregado correctamente");
            } catch (\Exception $e) {
                return response()->json(['Error al ingresar el almacen'], 500);

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
                Almacen::where('id', $datosRequest[0])->update([
                    'Nombre' => $datosRequest[1],
                    'Precio' => $datosRequest[2],
                    'TipoMoneda' => $datosRequest[3],
                    'Stock' => $datosRequest[4],
                ]);
                return response()->json("almacen modificado correctamente");
            } catch (\Exception $e) {
                return response()->json(['Error al modificar el almacen'], 500);
            }
        }
    }

    public function eliminar(Request $request)
    {
        $id = $request->get('identificador'); {
            try {
                Almacen::where('id', $id)->delete();
                return response()->json(['Almacen eliminado correctamente']);
            } catch (\Exception $e) {
                return response()->json(['Error al eliminar el almacen'], 500);
            }
        }
    }

    public function recuperar(Request $request)
    {
        $id = $request->get('identificador');
        $almacen = Almacen::withTrashed()->find($id);
        if ($almacen) {
            try {
                Almacen::where('id', $id)->restore();
                return response()->json(['El almacen a sido restaurado']);
            } catch (\Exception $e) {
                return response()->json(['Error al restaurar el almacen'], 500);
            }
        } else {
            return response()->json(['El almacen no puede ser recuperado porque ya existe']);
        }
    }
}
