<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Lote;
use App\Models\LugarEntrega;
use App\Models\Paquete;
use App\Models\PaqueteContieneLote;
use Illuminate\Http\Request;

class paqueteContieneLoteController extends Controller
{
    public function cargarDatos()
    {
        $datosLote = Lote::withTrashed()->get();
        $infoLote = [];
        if ($datosLote) {
            foreach ($datosLote as $lote) {
                $datosPaquete = PaqueteContieneLote::withTrashed()->where('IdLote', $lote['Id'])->get();
                if ($datosPaquete) {
                    foreach ($datosPaquete as $paquete) {
                        $almacen = Almacen::withTrashed()->where('Id', $paquete['IdAlmacen'])->first();
                        $objeto = Paquete::withTrashed()->where('Id', $paquete['IdPaquete'])->first();
                        $infoLote[] = [
                            'Id Lote' => $lote['Id'],
                            'Id Paquete' => $paquete['IdPaquete'],
                            'Volumen(L)' => $objeto['VolumenL'],
                            'Peso(Kg)' => $objeto['PesoKg'],
                            'Almacen' => $almacen['Id'],
                            'created_at' => $paquete['created_at'],
                            'updated_at' => $paquete['updated_at'],
                            'deleted_at' => $paquete['deleted_at']
                        ];

                    }
                }
            }
        }
        return response()->json($infoLote);
    }

    public function agregar(Request $request)
    {
        try {

            $datosRequest = $request->all();
            $paqueteExistente = PaqueteContieneLote::where('IdPaquete', $datosRequest[1])->first();
            if (!$paqueteExistente) {
                $paqueteContieneLote = new PaqueteContieneLote;
                $paqueteContieneLote->idLote = $datosRequest[0];
                $paqueteContieneLote->idPaquete = $datosRequest[1];
                $paqueteContieneLote->idAlmacen = $datosRequest[2];
                $paqueteContieneLote->save();
                $valores = Paquete::withTrashed()->where('Id', $datosRequest[1])->first();
                $lote = Lote::withTrashed()->where('Id', $datosRequest[0])->first();
                $volumen = $lote['VolumenL'] + $valores['VolumenL'];
                $peso = $lote['PesoKg'] + $valores['PesoKg'];
                Lote::withTrashed()->where('Id', $datosRequest[0])->update([
                    'VolumenL' => $volumen,
                    'PesoKg' => $peso
                ]);
                return response()->json('Paquete agregado');
            } else {
                return response()->json('El paquete ya pertenece a un lote');
            }
        } catch (\Exception $e) {
            return response()->json(['Error al modificar el almacen'], 500);
        }

    }
    public function modificar(Request $request)
    {
        try {
            $datosRequest = $request->all();
            $paqueteAntiguo = PaqueteContieneLote::where('IdPaquete', $datosRequest[0])->first();
            $valoresAntiguos = Paquete::withTrashed()->where('Id', $paqueteAntiguo['IdPaquete'])->first();
            $loteAntiguo = Lote::withTrashed()->where('Id', $paqueteAntiguo['IdLote'])->first();
            $volumen = $loteAntiguo['VolumenL'] - $valoresAntiguos['VolumenL'];
            $peso = $loteAntiguo['PesoKg'] - $valoresAntiguos['PesoKg'];
            Lote::withTrashed()->where('Id', $paqueteAntiguo['IdLote'])->update([
                'VolumenL' => $volumen,
                'PesoKg' => $peso
            ]);
            PaqueteContieneLote::where('IdPaquete', $datosRequest[0])->update([
                'IdLote' => $datosRequest[1],
                'IdPaquete' => $datosRequest[2],
                'IdAlmacen' => $datosRequest[3],
            ]);

            $valores = Paquete::withTrashed()->where('Id', $datosRequest[2])->first();
            $lote = Lote::withTrashed()->where('Id', $datosRequest[1])->first();
            $volumen = $lote['VolumenL'] + $valores['VolumenL'];
            $peso = $lote['PesoKg'] + $valores['PesoKg'];
            Lote::withTrashed()->where('Id', $datosRequest[1])->update([
                'VolumenL' => $volumen,
                'PesoKg' => $peso
            ]);
            return response()->json('Lote modificado agregado');

        } catch (\Exception $e) {
            return response()->json(['Error al modificar el almacen'], 500);
        }
    }

    public function eliminar(Request $request)
    {
        $id = $request->get('identificador'); {
            try {
                $paqueteAntiguo = PaqueteContieneLote::where('IdPaquete', $id)->first();
                $valoresAntiguos = Paquete::withTrashed()->where('Id', $paqueteAntiguo['IdPaquete'])->first();
                $loteAntiguo = Lote::withTrashed()->where('Id', $paqueteAntiguo['IdLote'])->first();
                $volumen = $loteAntiguo['VolumenL'] - $valoresAntiguos['VolumenL'];
                $peso = $loteAntiguo['PesoKg'] - $valoresAntiguos['PesoKg'];
                Lote::withTrashed()->where('Id', $paqueteAntiguo['IdLote'])->update([
                    'VolumenL' => $volumen,
                    'PesoKg' => $peso
                ]);
                PaqueteContieneLote::where('IdPaquete', $id)->delete();

                return response()->json(['Almacen eliminado correctamente']);
            } catch (\Exception $e) {
                return response()->json(['Error al eliminar el almacen'], 500);
            }
        }
    }

    public function recuperar(Request $request)
    {
        $id = $request->get('identificador');
        $paqueteContieneLote = PaqueteContieneLote::withTrashed()->where('IdPaquete',$id)->first();

        if ($paqueteContieneLote) {
            try {

                PaqueteContieneLote::withTrashed()->where('IdPaquete', $id)->restore();
                $paquete = PaqueteContieneLote::where('IdPaquete', $id)->first();
                $valoresAntiguos = Paquete::withTrashed()->where('Id', $paquete['IdPaquete'])->first();
                $valoresNuevos = $paquete;
                $lote = Lote::withTrashed()->where('Id', $paquete['IdLote'])->first();
                $volumen = $lote['VolumenL'] + ($valoresNuevos['VolumenL'] - $valoresAntiguos['VolumenL']);
                $peso = $lote['PesoKg'] + ($valoresNuevos['PesoKg'] - $valoresAntiguos['PesoKg']);

                Lote::withTrashed()->where('Id', $paquete['IdLote'])->update([
                    'VolumenL' => $volumen,
                    'PesoKg' => $peso
                ]);

                return response()->json(['Paquete restaurado correctamente']);
            } catch (\Exception $e) {
                return response()->json(['Error al restaurar el Paquete'], 500);
            }
        } else {
            return response()->json(['El paquete no puede ser recuperado porque ya existe']);
        }

    }

}