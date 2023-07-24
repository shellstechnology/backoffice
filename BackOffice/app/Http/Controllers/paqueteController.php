<?php

namespace App\Http\Controllers;

use App\Models\Caracteristica;
use App\Models\LugarEntrega;
use App\Models\Paquete;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class paqueteController extends Controller
{
    public function cargarDatos()
    {
        $datoProducto = Paquete::withTrashed()->get();
        foreach ($datoProducto as $dato) {
            $lugarEntrega = LugarEntrega::withTrashed()->find($dato['IdLugarEntrega']);
            $caracteristica = Caracteristica::withTrashed()->find($dato['IdCaracteristica']);
            $producto = Producto::withTrashed()->find($dato['IdProducto']);
            if($producto){
                $infoPaquete[] =
                    [
                        'Id Paquete' => $dato['Id'],
                        'Fecha de Entrega' => $dato['FechaDeEntrega'],
                        'Id Lugar Entrega' => $lugarEntrega['Id'],
                        'Direccion' => $lugarEntrega['Direccion'],
                        'Caracteristicas' => $caracteristica['Descripcion'],
                        'Nombre del Remitente' => $dato['NombreRemitente'],
                        'Nombre del Destinatario' => $dato['NombreDestinatario'],
                        'Id del Producto' => $producto['Id'],
                        'Producto' => $producto['Nombre'],
                        'Volumen(L)' => $dato['VolumenL'],
                        'Peso(Kg)' => $dato['PesoKg'],
                        'created_at' => $dato['created_at'],
                        'updated_at' => $dato['updated_at'],
                        'deleted_at' => $dato['deleted_at'],
                    ];
                }
          

        }
        return response()->json($infoPaquete);
    }

    public function agregar(Request $request)
    { {
            try{
                $datosRequest = $request->all();
                $reglas = [
                    'Caracteristica' => 'required|string|max:100',
                    'Nombre Remitente' => 'required|string|max:20',
                    'Nombre Destinatario' => 'required|string|max:20',
                    'Volumen' => 'required|numeric|min:1|max:999',
                    'Peso' => 'required|numeric|min:1|max:999',
                ];
                $validador = Validator::make([
                    'Caracteristica' => $datosRequest[4],
                    'Nombre Remitente' => $datosRequest[5],
                    'Nombre Destinatario' => $datosRequest[6],
                    'Volumen' => $datosRequest[8],
                    'Peso' => $datosRequest[9],
                ], $reglas);

                if ($validador->fails()) {
                    $errores = $validador->getMessageBag();
                    return response()->json(['error:' => $errores], 422);
                }
                $caracteristica=new Caracteristica;
                $caracteristica->descripcion=$datosRequest[4];
                $caracteristica->save();
                $dia = $datosRequest[2];
                $mes = $datosRequest[1];
                $anio = $datosRequest[0];
                $fechaEntrega = sprintf('%04d-%02d-%02d', $anio, $mes, $dia);
                $paquete = new Paquete;
                $paquete->FechaDeEntrega=$fechaEntrega;
                $paquete->IdLugarEntrega=$datosRequest[3];
                $paquete->IdCaracteristica=$caracteristica->id;
                $paquete->NombreRemitente=$datosRequest[5];
                $paquete->NombreDestinatario=$datosRequest[6];
                $paquete->IdProducto=$datosRequest[7];
                $paquete->VolumenL=$datosRequest[8];
                $paquete->PesoKg=$datosRequest[9];
                $paquete->save();

                return response()->json($datosRequest);
            }catch(\Exception $e){
                return response()->json(['Error al modificar el almacen'], 500);
            }
        }
    }
    public function modificar(Request $request)
    { {
            try {
                $datosRequest = $request->all();
                $reglas = [
                    'Caracteristica' => 'required|string|max:100',
                    'Nombre Remitente' => 'required|string|max:20',
                    'Nombre Destinatario' => 'required|string|max:20',
                    'Volumen' => 'required|numeric|min:1|max:999',
                    'Peso' => 'required|numeric|min:1|max:999',
                ];
                $validador = Validator::make([
                    'Caracteristica' => $datosRequest[5],
                    'Nombre Remitente' => $datosRequest[6],
                    'Nombre Destinatario' => $datosRequest[7],
                    'Volumen' => $datosRequest[9],
                    'Peso' => $datosRequest[10],
                ], $reglas);

                if ($validador->fails()) {
                    $errores = $validador->getMessageBag();
                    return response()->json(['error:' => $errores], 422);
                }
                $paquete = Paquete::where('Id', $datosRequest[0])->first();
                Caracteristica::where('Id', $paquete['IdCaracteristica'])->update([
                    'Descripcion' => $datosRequest[5]
                ]);
                $dia = $datosRequest[3];
                $mes = $datosRequest[2];
                $anio = $datosRequest[1];
                $fechaEntrega = sprintf('%04d-%02d-%02d', $anio, $mes, $dia);
                Paquete::where('Id', $datosRequest[0])->update([
                    'FechaDeEntrega' => $fechaEntrega,
                    'NombreRemitente' => $datosRequest[6],
                    'NombreDestinatario' => $datosRequest[7],
                    'IdProducto' => $datosRequest[8],
                    'VolumenL' => $datosRequest[9],
                    'PesoKg' => $datosRequest[10],
                ]);
                return response()->json($datosRequest);
            } catch (\Exception $e) {
                return response()->json(['Error al modificar el almacen'], 500);
            }
        }
    }
    public function eliminar(Request $request){
        $id = $request->get('identificador'); {
            try {
                $paquete = Paquete::where('Id',$id )->first();
                Caracteristica::where('Id', $paquete['IdCaracteristica'])->delete();
                Paquete::where('Id',$id )->delete();
                return response()->json(['Paquete eliminado correctamente']);
            } catch (\Exception $e) {
                return response()->json(['Error al eliminar el Paquete'], 500);
            }
        }
    }

    public function recuperar(Request $request)
    {
        $id = $request->get('identificador');
        $paquete = Paquete::withTrashed()->find($id);
        if ($paquete) {
            try {
                Caracteristica::where('Id', $paquete['IdCaracteristica'])->restore();
                Paquete::where('Id',$id )->restore();
                return response()->json(['Paquete restaurado correctamente']);
            } catch (\Exception $e) {
                return response()->json(['Error al restaurar el Paquete'], 500);
            }
        } else {
            return response()->json(['El paquete no puede ser recuperado porque ya existe']);
        }
    }

}