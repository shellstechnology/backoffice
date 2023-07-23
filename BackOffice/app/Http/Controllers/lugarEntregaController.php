<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\LugarEntrega;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class lugarEntregaController extends Controller
{
    public function cargarDatos()
    {
        $infoLugar = [];
        $datoAlmacen = Almacen::withTrashed()->get();
        $datoLugar = LugarEntrega::withTrashed()->get();
        foreach ($datoLugar as $dato) {
                foreach ($datoAlmacen as $datoA) {
                    if ($datoA->IdLugarDeEntrega) {
                        $infoLugar[] = [
                            'Id Lugar' => $dato->Id,
                            'Id Almacen' => $datoA->Id,
                            'Direccion Lugar' => $dato->Direccion,
                            'Lat Lugar' => $dato->Latitud,
                            'Lng Lugar' => $dato->Longitud,
                            'created_at' => $datoA->created_at,
                            'updated_at' => $datoA->updated_at,
                            'deleted_at' => $datoA->deleted_at,
                        ];
                    }
                }
                return response()->json($infoLugar);
        }
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

                Almacen::where('Id', $datosRequest[0])->update([
                    'IdLugarDeEntrega' => $lugarEntrega->id
                ]);
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
                $almacen = Almacen::where('Id', $datosRequest[0])->first();
                $datoLugar = LugarEntrega::where('Id', $almacen['IdLugarDeEntrega'])->update([
                    'Direccion' => $datosRequest[2],
                    'Latitud' => $datosRequest[3],
                    'Longitud' => $datosRequest[4],
                ]);
                Almacen::where('IdLugarDeEntrega', $datoLugar)->update([
                    'IdLugarDeEntrega' => null
                ]);


                return response()->json($almacen);
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
                Almacen::where('IdLugarDeEntrega', $id)->update([
                    'IdLugarDeEntrega' => null
                ]);
                return response()->json(['Almacen eliminado correctamente']);
            } catch (\Exception $e) {
                return response()->json(['Error al eliminar el almacen'], 500);
            }
        }
    }



}