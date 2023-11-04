<?php

namespace App\Http\Controllers;

use App\Models\camion_lleva_lote;
use App\Models\camiones;
use App\Models\lotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class cargarDatosController extends Controller
{
    public function cargarDatos()
    {
        $datosCamionLlevaLote = Camion_Lleva_Lote::withTrashed()->get();
        $infoCamionLlevaLote = [];
        $matriculaCamion = [];
        $idLote = [];
        foreach ($datosCamionLlevaLote as $camionLlevaLote) {
            $infoCamionLlevaLote[] = $this->obtenerCamionLlevaLote($camionLlevaLote);
        }
        $camiones = Camiones::withoutTrashed()->get();
        foreach ($camiones as $camion) {
            $matriculaCamion[] = $camion['matricula'];
        }
        $lote = Lotes::withoutTrashed()->get();
        foreach ($lote as $datoLote) {
            $idLote[] = $datoLote['id'];
        }
        Session::put('matriculaCamiones', $matriculaCamion);
        Session::put('idLotes', $idLote);
        Session::put('camionLlevaLote', $infoCamionLlevaLote);
        return redirect()->route('camion.camionLlevaLote');
    }

    private function obtenerCamionLlevaLote($camionLlevaLote)
    {
        $infoCamionLlevaLote = [
            'Id Lote' => $camionLlevaLote['id_lote'],
            'Matricula Camion' => $camionLlevaLote['matricula'],
            'created_at' => $camionLlevaLote['created_at'],
            'updated_at' => $camionLlevaLote['updated_at'],
            'deleted_at' => $camionLlevaLote['deleted_at']
        ];
        return $infoCamionLlevaLote;
    }

}
