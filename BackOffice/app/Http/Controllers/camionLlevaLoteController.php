<?php

namespace App\Http\Controllers;

use App\Models\Camion_Lleva_Lote;
use App\Models\Camiones;
use App\Models\Lotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class camionLlevaLoteController extends Controller
{
    public function realizarAccion(Request $request)
    {
        $datosRequest = $request->all();
        if ($request->has('cbxAgregar')) {
            $this->agregar($datosRequest);
        }
        if ($request->has('cbxModificar')) {
            $this->modificar($datosRequest);
        }
        if ($request->has('cbxEliminar')) {
            $this->eliminar($datosRequest);
        }
        if ($request->has('cbxRecuperar')) {
            $this->recuperar($datosRequest);
        }
        $this->cargarDatos();
        return redirect()->route('camion.camionLlevaLote');
    }
    public function cargarDatos()
    {
        $datosCamionLlevaLote = Camion_Lleva_Lote::withTrashed()->get();
        $infoCamionLlevaLote = [];
        $matriculaCamion = [];
        $idLote = [];
        foreach ($datosCamionLlevaLote as $camionLlevaLote) {
            $infoCamionLlevaLote[] = $this->definirCamionLlevaLote($camionLlevaLote);
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

    public function agregar($datosRequest)
    {
        $camionLlevaLoteExistente = Camion_Lleva_Lote::where('id_lote', $datosRequest['idLote'])->first();
        if (!$camionLlevaLoteExistente) {
            $this->crearCamionLlevaLote($datosRequest);
        }
    }
    public function modificar($datosRequest)
    {
        $this->modificarCamionLlevaLote($datosRequest);
    }

    public function eliminar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $camionLlevaLoteAntiguo = Camion_Lleva_Lote::withoutTrashed()->where('id_lote', $id)->first();
        if ($camionLlevaLoteAntiguo) {
            $camionLlevaLoteAntiguo->delete();
        }
    }

    public function recuperar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $camionLlevaLote = Camion_Lleva_Lote::onlyTrashed()->where('id_lote', $id)->first();

        if ($camionLlevaLote) {
            $camionLlevaLote->restore();
        }
    }

    private function definirCamionLlevaLote($camionLlevaLote)
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

    private function crearCamionLlevaLote($camionLlevaLote)
    {
        $id=$camionLlevaLote['idLote'];
        $matricula=$camionLlevaLote['idCamion'];
        $camionLlevaLote = new Camion_Lleva_Lote;
        $camionLlevaLote->id_lote =$id;
        $camionLlevaLote->matricula = $matricula;
        $camionLlevaLote->save();
    }


    private function modificarCamionLlevaLote($camionLlevaLote)
    {
        Camion_Lleva_Lote::withTrashed()->where('id_lote', $camionLlevaLote['identificador'])->update([
            'id_lote'=>$camionLlevaLote['idLote'],
            'matricula'=>$camionLlevaLote['idCamion']
        ]);
    }

}
