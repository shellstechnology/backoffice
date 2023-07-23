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
        $datoAlmacen = Almacen::withTrashed()->get();
        foreach ($datoAlmacen as $dato) {
            $almacen = DireccionAlmacen::withTrashed()->findOrFail($dato['IdDireccionAlmacen']);
            $infoAlmacen[]=
            [
                'Id Almacen'=>$dato['Id'],
                'Direccion Almacen'=>$almacen['Direccion'],
                'Lat Almacen'=>$almacen['Latitud'],
                'Lng Almacen'=>$almacen['Longitud'],
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
                $almacen = Almacen::where('Id', $datosRequest[0])->first();
                DireccionAlmacen::where('Id', $almacen['IdDireccionAlmacen'])->update([
                    'Direccion' => $datosRequest[1],
                    'Latitud' => $datosRequest[2],
                    'Longitud' => $datosRequest[3],
                ]);

                return response()->json($almacen);
            } catch (\Exception $e) {
                return response()->json(['Error al modificar el almacen'], 500);
            }
        }
    }

    public function eliminar(Request $request)
    {
        $id = $request->get('identificador'); {
            try {
                $almacen = Almacen::where('Id',$id )->first();
                DireccionAlmacen::where('Id', $almacen['IdDireccionAlmacen'])->delete();
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
        $almacen = Almacen::withTrashed()->find($id);
        if ($almacen) {
            try {
                Almacen::where('Id',$id )->restore();
                DireccionAlmacen::where('Id', $almacen['IdDireccionAlmacen'])->restore();
                return response()->json(['Almacen restaurado correctamente']);
            } catch (\Exception $e) {
                return response()->json(['Error al restaurar el almacen'], 500);
            }
        } else {
            return response()->json(['El almacen no puede ser recuperado porque ya existe']);
        }
    }
}