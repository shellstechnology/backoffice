<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class loteController extends Controller
{
    public function cargarDatos()
    {
        $datoLote = Lote::withTrashed()->get();
        $infoLote = [];
        if ($datoLote) {
            foreach ($datoLote as $lote) {
                $infoLote[] = [
                    'Id Lote' => $lote['Id'],
                    'Volumen(L)' => $lote['VolumenL'],
                    'Peso(Kg)' => $lote['PesoKg'],
                    'created_at' => $lote['created_at'],
                    'updated_at' => $lote['updated_at'],
                    'deleted_at' => $lote['deleted_at'],
                ];
            }
            return response()->json($infoLote);
        }

        return response()->json('No hay ningun lote');
    }

    public function crearLote()
    {
        $lote = new Lote;
        $lote->VolumenL = 0;
        $lote->PesoKg = 0;
        $lote->save();
        return response()->json('Lote creado');
    }

    public function eliminar(Request $request){
        $id = $request->get('identificador'); {
            try {
                Lote::where('Id',$id )->delete();
                return response()->json(['Paquete eliminado correctamente']);
            } catch (\Exception $e) {
                return response()->json(['Error al eliminar el Paquete'], 500);
            }
        }
    }

    public function recuperar(Request $request){
        $id = $request->get('identificador');
        $lote = Lote::withTrashed()->find($id);
        if ($lote) {
            try {
                Lote::where('Id',$id )->restore();
                return response()->json(['Lote restaurado correctamente']);
            } catch (\Exception $e) {
                return response()->json(['Error al restaurar el Lote'], 500);
            }
        } else {
            return response()->json(['El Lote no puede ser recuperado porque ya existe']);
        }
    }
}