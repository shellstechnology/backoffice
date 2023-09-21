<?php

namespace App\Http\Controllers;

use App\Models\Lotes;
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
        $datoLote = Lotes::withTrashed()->get();
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
        $lote = new Lotes;
        $lote->volumen_l = 0;
        $lote->peso_kg = 0;
        $lote->save();
    }

    public function eliminar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $lote = Lotes::withoutTrashed()->find($id);
        if ($lote) {
            Lotes::where('id', $datosRequest['identificador'])->delete();
        }
    }

    public function recuperar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $lote = Lotes::onlyTrashed()->find($id);
        if ($lote) {
            Lotes::where('id', $id)->restore();
        }
        return redirect()->route('backoffice.lote');
    }

    private function obtenerDatosLotes($lote)
    {

        return ([
            'Id Lote' => $lote['id'],
            'Volumen(L)' => $lote['volumen_l'],
            'Peso(Kg)' => $lote['peso_kg'],
            'created_at' => $lote['created_at'],
            'updated_at' => $lote['updated_at'],
            'deleted_at' => $lote['deleted_at'],
        ]);

    }
}