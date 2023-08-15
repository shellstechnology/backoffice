<?php

namespace App\Http\Controllers;

use App\Models\Almacenes;
use App\Models\Lotes;
use App\Models\Lugares_Entrega;
use App\Models\Paquetes;
use App\Models\Paquete_Contiene_Lote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class paqueteContieneLoteController extends Controller
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
        return redirect()->route('lote.paqueteContieneLote');
    }
    public function cargarDatos()
    {
        $datosPaqueteContieneLote = Paquete_Contiene_Lote::withTrashed()->get();
        $infoPaqueteContieneLote = [];
        $idAlmacen = [];
        $idPaquete = [];
        $idLote = [];
        foreach ($datosPaqueteContieneLote as $paqueteContieneLote) {
            $infoPaqueteContieneLote[] = $this->definifPaquete($paqueteContieneLote);
        }
        $lugarAlmacen = Lugares_Entrega::withoutTrashed()->get();
        foreach ($lugarAlmacen as $datoLugar) {
            $idAlmacen[] = $datoLugar['id'];
        }
        $paquete = Paquetes::withoutTrashed()->get();
        foreach ($paquete as $datoPaquete) {
            $idPaquete[] = $datoPaquete['id'];
        }
        $lote = Lotes::withoutTrashed()->get();
        foreach ($lote as $datoLote) {
            $idLote[] = $datoLote['id'];
        }
        Session::put('idAlmacenes', $idAlmacen);
        Session::put('idPaquetes', $idPaquete);
        Session::put('idLotes', $idLote);
        Session::put('paqueteContieneLote', $infoPaqueteContieneLote);
        return redirect()->route('lote.paqueteContieneLote');
    }

    public function agregar($datosRequest)
    {
        $paqueteExistente = Paquete_Contiene_Lote::where('id_paquete', $datosRequest['idPaquete'])->first();
        if (!$paqueteExistente) {
            $this->crearPaquete($datosRequest);
        }
    }
    public function modificar($datosRequest)
    {
        $this->modificarValoresAntiguos($datosRequest);
        $this->modificarValoresNuevos($datosRequest);
    }

    public function eliminar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $paqueteAntiguo = Paquete_Contiene_Lote::onlyTrashed()->where('id_paquete', $id)->first();
        if ($paqueteAntiguo) {
            $this->eliminarPaqueteContieneLote($paqueteAntiguo, $id);
        }

    }

    public function recuperar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $paqueteContieneLote = Paquete_Contiene_Lote::withTrashed()->where('id_paquete', $id)->first();

        if ($paqueteContieneLote) {
            Paquete_Contiene_Lote::onlyTrashed()->where('IdPaquete', $id)->restore();
            $this->recuperarValoresPaquete($id);
        }
    }

    private function definirPaquete($paqueteContieneLote)
    {
        $datosLote = Paquete_Contiene_Lote::withTrashed()->where('id_lote', $paqueteContieneLote['idLote'])->get();
        $datosAlmacen = Almacenes::withTrashed()->where('Id', $paqueteContieneLote['idAlmacen'])->first();
        $datosPaquete = Paquetes::withTrashed()->where('Id', $paqueteContieneLote['idPaquete'])->first();
        $infoPaquete = [
            'Id Lote' => $datosLote['id'],
            'Id Paquete' => $datosPaquete['id'],
            'Volumen(L)' => $datosPaquete['volumen_l'],
            'Peso(Kg)' => $datosPaquete['peso_kg'],
            'Almacen' => $datosAlmacen['id'],
            'created_at' => $paqueteContieneLote['created_at'],
            'updated_at' => $paqueteContieneLote['updated_at'],
            'deleted_at' => $paqueteContieneLote['deleted_at']
        ];

        return $infoPaquete;
    }

    private function crearPaquete($paquete)
    {
        $paqueteContieneLote = new Paquete_Contiene_Lote;
        $paqueteContieneLote->idLote = $paquete['idLote'];
        $paqueteContieneLote->idPaquete = $paquete['idPaquete'];
        $paqueteContieneLote->idAlmacen = $paquete['idAlmacen'];
        $paqueteContieneLote->save();
        $this->crearLote($paquete);
    }


    private function crearLote($paquete)
    {
        $valores = Paquetes::withTrashed()->where('id', $paquete['idPaquete'])->first();
        $lote = Lotes::withTrashed()->where('id', $paquete['idLote'])->first();
        $peso = $valores['peso_kg'] + $lote['peso_kg'];
        $volumen = $valores['volumen_l'] + $lote['volumen_l'];
        $lote->update([
            'volumen_l' => $volumen,
            'peso_kg' => $peso
        ]);
    }

    private function modificarValoresAntiguos($datosRequest)
    {
        $paqueteAntiguo = Paquete_Contiene_Lote::where('id_paquete', $datosRequest['identificador'])->first();
        $valoresAntiguos = Paquetes::withTrashed()->where('id', $paqueteAntiguo['idPaquete'])->first();
        $loteAntiguo = Lotes::withTrashed()->where('id', $paqueteAntiguo['idLote'])->first();
        $volumen = $loteAntiguo['volumen_l'] - $valoresAntiguos['volumen_l'];
        $peso = $loteAntiguo['peso_kg'] - $valoresAntiguos['peso_kg'];
        Lotes::withTrashed()->where('id', $paqueteAntiguo['idLote'])->update([
            'volumen_l' => $volumen,
            'peso_kg' => $peso
        ]);
        Paquete_Contiene_Lote::where('id_paquete', $datosRequest['identificador'])->update([
            'id_lote' => $datosRequest['idLote'],
            'id_paquete' => $datosRequest['idPaquete'],
            'id_almacen' => $datosRequest['idAlmacen'],
        ]);
    }

    private function modificarValoresNuevos($datosRequest)
    {
        $valores = Paquetes::withTrashed()->where('id', $datosRequest['idPaquete'])->first();
        $lote = Lotes::withTrashed()->where('id', $datosRequest['idPaquete'])->first();
        $volumen = $lote['volumen_l'] + $valores['volumen_l'];
        $peso = $lote['peso_kg'] + $valores['peso_kg'];
        Lotes::withTrashed()->where('id', $datosRequest['idLote'])->update([
            'volumen_l' => $volumen,
            'peso_kg' => $peso
        ]);
    }

    private function eliminarPaqueteContieneLote($paqueteAntiguo, $id)
    {
        $valoresAntiguos = Paquetes::withTrashed()->where('Id', $paqueteAntiguo['IdPaquete'])->first();
        $loteAntiguo = Lotes::withTrashed()->where('Id', $paqueteAntiguo['IdLote'])->first();
        $volumen = $loteAntiguo['volumen_l'] - $valoresAntiguos['volumen_l'];
        $peso = $loteAntiguo['peso_kg'] - $valoresAntiguos['peso_kg'];
        Lotes::withTrashed()->where('id', $paqueteAntiguo['id_lote'])->update([
            'volumen_l' => $volumen,
            'peso_kg' => $peso
        ]);
        Paquete_Contiene_Lote::where('IdPaquete', $id)->delete();
    }

    private function recuperarValoresPaquete($id)
    {
        $paquete = Paquete_Contiene_Lote::where('id_paquete', $id)->first();
        $valoresAntiguos = Paquetes::withTrashed()->where('id', $paquete['id_paquete'])->first();
        $valoresNuevos = $paquete;
        $lote = Lotes::withTrashed()->where('id', $paquete['id_lote'])->first();
        $volumen = $lote['volumen_l'] + ($valoresNuevos['volumen_l'] - $valoresAntiguos['volumen_l']);
        $peso = $lote['peso_kg'] + ($valoresNuevos['peso_kg'] - $valoresAntiguos['peso_kg']);

        Lotes::withTrashed()->where('id', $paquete['id_lote'])->update([
            'volumen_l' => $volumen,
            'peso_kg' => $peso
        ]);

    }
}