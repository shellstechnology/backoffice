<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\DireccionAlmacen;
use App\Models\LugarEntrega;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class lugarEntregaController extends Controller
{
    public function cargarDatos()
    {
        $infoAlmacen = [];
        $datoAlmacen = Almacen::withTrashed()->get();

        foreach ($datoAlmacen as $dato) {
            $direccionAlmacen = DireccionAlmacen::withTrashed()->where('Id', $dato['IdDireccionAlmacen'])->first();
            $lugarEntrega = LugarEntrega::withTrashed()->where('Id', $dato['IdLugarDeEntrega'])->first();

            if ($direccionAlmacen) {
                if ($lugarEntrega) {
                    $infoAlmacen[] = [
                        'Id Lugar' => $lugarEntrega['Id'],
                        'Direccion Lugar' => $lugarEntrega['Direccion'],
                        'Id Almacen' => $direccionAlmacen['Id'],
                        'Direccion Almacen' => $direccionAlmacen['Direccion'],
                        'Lat Lugar' => $lugarEntrega['Latitud'],
                        'Lng Lugar' => $lugarEntrega['Longitud'],
                        'created_at' => $lugarEntrega['created_at'],
                        'updated_at' => $lugarEntrega['updated_at'],
                        'deleted_at' => $lugarEntrega['deleted_at'],
                    ];
                }
            }
        }

        return response()->json($infoAlmacen);
    }

    public function agregar(Request $request)
    { {
            try {
                $datosRequest = $request->all();
                $reglas = [
                    'Direccion Lugar' => 'required|string|max:25',
                    'Lat Lugar' => 'required|numeric|min:-90|max:90',
                    'Lng Lugar' => 'required|numeric|min:-180|max:180'
                ];
                $validador = Validator::make([
                    'Direccion Lugar' => $datosRequest[1],
                    'Lat Lugar' => $datosRequest[2],
                    'Lng Lugar' => $datosRequest[3],
                ], $reglas);

                if ($validador->fails()) {
                    $errores = $validador->getMessageBag();
                    return response()->json(['error:' => $errores], 422);
                }
                $lugarEntrega = new LugarEntrega;
                $lugarEntrega->Direccion = $datosRequest[1];
                $lugarEntrega->Latitud = $datosRequest[2];
                $lugarEntrega->Longitud = $datosRequest[3];
                $lugarEntrega->save();

                $almacen = new Almacen;
                $almacen->IdDireccionAlmacen = $datosRequest[0];
                $almacen->IdLugarDeEntrega = $lugarEntrega->id;
                $almacen->save();
                return response()->json('Lugar agregado');
            } catch (\Exception $e) {
                return response()->json(['Error al ingresar el lugar'], 500);

            }
        }
    }

    public function modificar(Request $request)
    { {
            try {
                $datosRequest = $request->all();
                $reglas = [
                    'Direccion Lugar' => 'required|string|max:25',
                    'Lat Lugar' => 'required|numeric|min:-90|max:90',
                    'Lng Lugar' => 'required|numeric|min:-180|max:180'
                ];
                $validador = Validator::make([
                    'Direccion Lugar' => $datosRequest[2],
                    'Lat Lugar' => $datosRequest[3],
                    'Lng Lugar' => $datosRequest[4],
                ], $reglas);

                if ($validador->fails()) {
                    $errores = $validador->getMessageBag();
                    return response()->json(['error:' => $errores], 422);
                }
                LugarEntrega::where('Id', $datosRequest[0])->update([
                    'Direccion' => $datosRequest[2],
                    'Latitud' => $datosRequest[3],
                    'Longitud' => $datosRequest[4],
                ]);
                $datoLugar = LugarEntrega::where('Id', $datosRequest[0])->first();
                Almacen::where('IdLugarDeEntrega', $datoLugar['Id'])->update([
                    'IdDireccionAlmacen'=>$datosRequest[1],
                    'IdLugarDeEntrega'=>$datosRequest[0]
                ]);
                return response()->json('Actualizado');
            } catch (\Exception $e) {
                return response()->json(['Error al modificar el lugar de entrega'], 500);
            }
        }
    }


    public function eliminar(Request $request)
    {
        $id = $request->get('identificador'); {
            try {
                LugarEntrega::where('Id', $id)->delete();
                return response()->json(['Almacen eliminado correctamente']);
            } catch (\Exception $e) {
                return response()->json(['Error al eliminar el almacen'], 500);
            }
        }
    }

    public function recuperar(Request $request)
    {
        $id = $request->get('identificador');
        $lugarEntrega= LugarEntrega::withTrashed()->find($id);
        if ($lugarEntrega) {
            try {
                LugarEntrega::where('Id', $id)->restore();
                return response()->json(['Almacen eliminado correctamente']);
            } catch (\Exception $e) {
                return response()->json(['Error al eliminar el almacen'], 500);
            }
        }
    }



}