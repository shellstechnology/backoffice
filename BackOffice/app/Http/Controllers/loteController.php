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
            $this->verificarDatosAgregar();
        }
        if ($request->has('cbxeliminarCamionLlevaLote')) {
            $this->eliminarLote($datosRequest);
        }
        if ($request->has('cbxRecuperar')) {
            $this->recuperarLote($datosRequest);
        }
        $this->cargarDatos();
        return redirect()->route('backoffice.lote');
    }

    public function cargarDatos()
    {
        try {
            $datoLote = Lotes::withTrashed()->get();
            $infoLote = [];
            if ($datoLote) {
                foreach ($datoLote as $lote) {
                    $infoLote[] = $this->obtenerDatosLotes($lote);
                }
                Session::put('lotes', $infoLote);

            }
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
        return redirect()->route('backoffice.lote');
    }

    public function verificarDatosAgregar()
    {
        try {
            $lote = new Lotes;
            $lote->volumen_l = 0;
            $lote->peso_kg = 0;
            $lote->save();
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
    }

    public function eliminarLote($datosRequest)
    {
        try {
            $id = $datosRequest['identificador'];
            $lote = Lotes::withoutTrashed()->find($id);
            if ($lote) {
                Lotes::where('id', $datosRequest['identificador'])->delete();
            }
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
    }

    public function recuperarLote($datosRequest)
    {
        try {


            $id = $datosRequest['identificador'];
            $lote = Lotes::onlyTrashed()->find($id);
            if ($lote) {
                Lotes::where('id', $id)->restore();
            }
            return redirect()->route('backoffice.lote');
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
    }

    private function obtenerDatosLotes($lote)
    {
        try {
            return ([
                'Id Lote' => $lote['id'],
                'Volumen(L)' => $lote['volumen_l'],
                'Peso(Kg)' => $lote['peso_kg'],
                'created_at' => $lote['created_at'],
                'updated_at' => $lote['updated_at'],
                'deleted_at' => $lote['deleted_at'],
            ]);
        }catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }

    }
}