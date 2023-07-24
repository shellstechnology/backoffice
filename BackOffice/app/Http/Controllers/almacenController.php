<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\DireccionAlmacen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class almacenController extends Controller
{
    public function cargarDatos()
    {   
        $infoAlmacen=[];
        $datoDireccion = DireccionAlmacen::withTrashed()->get();
        foreach ($datoDireccion as $dato) {
            $infoAlmacen[]=
            [
                'Id Almacen'=>$dato['Id'],
                'Direccion Almacen'=>$dato['Direccion'],
                'Lat Almacen'=>$dato['Latitud'],
                'Lng Almacen'=>$dato['Longitud'],
                'created_at'=>$dato['created_at'],
                'updated_at'=>$dato['updated_at'],
                'deleted_at'=>$dato['deleted_at'],
            ];

        }
        return response()->json($infoAlmacen);
    }

    public function agregar(Request $request)
    { {
            try {
                $datosRequest = $request->all();
                $reglas = [
                    'Direccion Almacen' => 'required|string|max:25',
                    'Lat Almacen' => 'required|numeric|min:-90|max:90',
                    'Lng Almacen' => 'required|numeric|min:-180|max:180'
                ];
                $validador = Validator::make([
                    'Direccion Almacen' => $datosRequest[0],
                    'Lat Almacen' => $datosRequest[1],
                    'Lng Almacen' => $datosRequest[2],
                ], $reglas);

                if ($validador->fails()) {
                    $errores = $validador->getMessageBag();
                    return response()->json(['error:' => $errores], 422);
                }
                $direccionAlmacen = new DireccionAlmacen;
                $direccionAlmacen->Direccion = $datosRequest[0];
                $direccionAlmacen->Latitud = $datosRequest[1];
                $direccionAlmacen->Longitud = $datosRequest[2];
                $direccionAlmacen->save(); 

                $almacen = new Almacen;
                $almacen->IdDireccionAlmacen=$direccionAlmacen->getKey();
                $almacen->save();
                return response()->json('Almacen agregado');
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
                    'Direccion Almacen' => 'required|string|max:25',
                    'Lat Almacen' => 'required|numeric|min:-90|max:90',
                    'Lng Almacen' => 'required|numeric|min:-180|max:180'
                ];
                $validador = Validator::make([
                    'Direccion Almacen' => $datosRequest[1],
                    'Lat Almacen' => $datosRequest[2],
                    'Lng Almacen' => $datosRequest[3],
                ], $reglas);

                if ($validador->fails()) {
                    $errores = $validador->getMessageBag();
                    return response()->json(['error:' => $errores], 422);
                }
                DireccionAlmacen::where('Id',$datosRequest[0])->update([
                    'Direccion' => $datosRequest[1],
                    'Latitud' => $datosRequest[2],
                    'Longitud' => $datosRequest[3],
                ]);

                return response()->json('Almacen Modificado');
            } catch (\Exception $e) {
                return response()->json(['Error al modificar el almacen'], 500);
            }
        }
    }

    public function eliminar(Request $request)
    {
        $id = $request->get('identificador'); {
            try {
                DireccionAlmacen::where('Id', $id)->delete();
                Almacen::where('Id',$id )->delete();
                return response()->json(['Almacen eliminado correctamente']);
            } catch (\Exception $e) {
                return response()->json(['Error al eliminar el almacen'], 500);
            }
        }
    }

    public function recuperar(Request $request)
    {
        $id = $request->get('identificador');
        $almacen = DireccionAlmacen::withTrashed()->find($id);
        if ($almacen) {
            try {
                DireccionAlmacen::where('Id', $id)->restore();
                Almacen::where('IdDireccionAlmacen',$id )->restore();
                return response()->json(['Almacen restaurado correctamente']);
            } catch (\Exception $e) {
                return response()->json(['Error al restaurar el almacen'], 500);
            }
        } else {
            return response()->json(['El almacen no puede ser recuperado porque ya existe']);
        }
    }
}