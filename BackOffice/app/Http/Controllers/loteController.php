<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class loteController extends Controller
{
    public function realizarAccion(Request $request)
    {
        $datosRequest = $request->all();
        if ($request->has('cbxAgregar')) {
            $this->agregar();
        }
        if ($request->has('cbxEliminar')) {
            $this->eliminar($datosRequest);
        }
        if ($request->has('cbxRecuperar')) {
            $this->recuperar($datosRequest);
        }
        $this->cargarDatos();
        return redirect()->route('backoffice.lote');
    }

    public function cargarDatos()
    {
        $datoLote = Lote::withTrashed()->get();
        $infoLote= [];
        if ($datoLote) {
            foreach ($datoLote as $lote) {
                $infoLote []= $this->obtenerDatosLotes($lote);
            }
            Session::put('lotes', $infoLote);
            return redirect()->route('backoffice.lote');
        }
    }

    public function agregar()
    {
        $lote = new Lote;
        $lote->VolumenL = 0;
        $lote->PesoKg = 0;
        $lote->save();
    }

    public function eliminar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $lote = Lote::withoutTrashed()->find($id);
        if ($lote) {
            Lote::where('Id', $datosRequest['identificador'])->delete();
        }
    }

    public function recuperar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $lote = Lote::onlyTrashed()->find($id);
        if ($lote) {
            Lote::where('Id', $id)->restore();
        }
        return redirect()->route('backoffice.lote');
    }

    private function obtenerDatosLotes($lote)
    {

        return ([
            'Id Lote' => $lote['Id'],
            'Volumen(L)' => $lote['VolumenL'],
            'Peso(Kg)' => $lote['PesoKg'],
            'created_at' => $lote['created_at'],
            'updated_at' => $lote['updated_at'],
            'deleted_at' => $lote['deleted_at'],
        ]);

    }
}