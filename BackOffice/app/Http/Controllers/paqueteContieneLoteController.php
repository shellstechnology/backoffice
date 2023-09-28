<?php

namespace App\Http\Controllers;

use App\Models\Almacenes;
use App\Models\Lotes;
use App\Models\Paquetes;
use App\Models\Paquete_Contiene_Lote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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
            $infoPaqueteContieneLote[] = $this->definirPaquete($paqueteContieneLote);
        }
        $lugarAlmacen = Almacenes::withoutTrashed()->get();
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
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            return;
        }
        $paqueteExistente = Paquete_Contiene_Lote::where('id_paquete', $datosRequest['idPaquete'])->first();
        if (!$paqueteExistente) {
            $this->crearPaqueteContieneLote($datosRequest);
        }
    }

    private function validarDatos($producto)
    {
        $reglas = [
            'idPaquete'=>'required|integer',
            'idLote' => 'required|integer',
            'idAlmacen' => 'required|integer',
        ];
        return Validator::make([
            'idPaquete'=>$producto['idPaquete'],
            'idLote' => $producto['idLote'],
            'idAlmacen' => $producto['idAlmacen'],
        ], $reglas);
    }

    public function modificar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            return;
        }
        $this->modificarValores($datosRequest);
    }

    public function eliminar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $paqueteAntiguo = Paquete_Contiene_Lote::withoutTrashed()->where('id_paquete', $id)->first();
        if ($paqueteAntiguo) {
            $paqueteAntiguo->delete();
        }
    }

    public function recuperar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $paqueteContieneLote = Paquete_Contiene_Lote::onlyTrashed()->where('id_paquete', $id)->first();

        if ($paqueteContieneLote) {
            $paqueteContieneLote->restore();
        }
    }

    private function definirPaquete($paqueteContieneLote)
    {
        $datosPaquete = Paquetes::withTrashed()->where('id', $paqueteContieneLote['id_paquete'])->first();
        $infoPaquete = [
            'Id Paquete' => $datosPaquete['id'],
            'Lote' => $paqueteContieneLote['id_lote'],
            'Volumen(L)' => $datosPaquete['volumen_l'],
            'Peso(Kg)' => $datosPaquete['peso_kg'],
            'Almacen' => $paqueteContieneLote['id_almacen'],
            'created_at' => $paqueteContieneLote['created_at'],
            'updated_at' => $paqueteContieneLote['updated_at'],
            'deleted_at' => $paqueteContieneLote['deleted_at']
        ];

        return $infoPaquete;
    }

    private function crearPaqueteContieneLote($paquete)
    {
        $paqueteContieneLote = new Paquete_Contiene_Lote;
        $paqueteContieneLote->id_paquete = $paquete['idPaquete'];
        $paqueteContieneLote->id_lote = $paquete['idLote'];
        $paqueteContieneLote->id_almacen = $paquete['idAlmacen'];
        $paqueteContieneLote->save();
    }


    private function actualizarLote($paquete)
    {
        $valores = Paquetes::withTrashed()->where('id', $paquete['idPaquete'])->first();
        $lote = Lotes::withTrashed()->where('id', $paquete['idLote'])->first();
        $peso = $valores['peso_kg'] + $lote['peso_kg'];
        $volumen = $valores['volumen_l'] + $lote['volumen_l'];
        Lotes::withTrashed()->where('id', $paquete['idLote'])->update([
            'peso_kg'=>$peso,
            'volumen_l'=>$volumen,

        ]);
    }

    private function modificarValores($datosRequest)
    {
        Paquete_Contiene_Lote::where('id_paquete', $datosRequest['identificador'])->update([
            'id_lote' => $datosRequest['idLote'],
            'id_paquete' => $datosRequest['idPaquete'],
            'id_almacen' => $datosRequest['idAlmacen'],
        ]);
    }
}