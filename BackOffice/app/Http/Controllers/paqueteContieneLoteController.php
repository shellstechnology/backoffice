<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\DireccionAlmacen;
use App\Models\Lote;
use App\Models\LugarEntrega;
use App\Models\Paquete;
use App\Models\PaqueteContieneLote;
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
        $datosPaqueteContieneLote = PaqueteContieneLote::withTrashed()->get();
        $infoPaqueteContieneLote = [];
        $idAlmacen = [];
        $idPaquete = [];
        $idLote = [];
        foreach ($datosPaqueteContieneLote as $paqueteContieneLote) {
            $infoPaqueteContieneLote[] = $this->definifPaquete($paqueteContieneLote);
        }
        $direccionAlmacen = DireccionAlmacen::withoutTrashed()->get();
        foreach ($direccionAlmacen as $datoDireccion) {
            $idAlmacen[] = $datoDireccion['Id'];
        }
        $paquete = Paquete::withoutTrashed()->get();
        foreach ($paquete as $datoPaquete) {
            $idPaquete[] = $datoPaquete['Id'];
        }
        $lote = Lote::withoutTrashed()->get();
        foreach ($lote as $datoLote) {
            $idLote[] = $datoLote['Id'];
        }
        Session::put('idAlmacenes', $idAlmacen);
        Session::put('idPaquetes', $idPaquete);
        Session::put('idLotes', $idLote);
        Session::put('paqueteContieneLote', $infoPaqueteContieneLote);
        return redirect()->route('lote.paqueteContieneLote');
    }

    public function agregar($datosRequest)
    {
        $paqueteExistente = PaqueteContieneLote::where('IdPaquete', $datosRequest['idPaquete'])->first();
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
        $paqueteAntiguo = PaqueteContieneLote::onlyTrashed()->where('IdPaquete', $id)->first();
        if ($paqueteAntiguo) {
            $this->eliminarPaqueteContieneLote($paqueteAntiguo, $id);
        }

    }

    public function recuperar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $paqueteContieneLote = PaqueteContieneLote::withTrashed()->where('IdPaquete', $id)->first();

        if ($paqueteContieneLote) {
            PaqueteContieneLote::onlyTrashed()->where('IdPaquete', $id)->restore();
            $this->recuperarValoresPaquete($id);
        }
    }

    private function definirPaquete($paqueteContieneLote)
    {
        $datosLote = PaqueteContieneLote::withTrashed()->where('IdLote', $paqueteContieneLote['IdLote'])->get();
        $datosAlmacen = Almacen::withTrashed()->where('Id', $paqueteContieneLote['IdAlmacen'])->first();
        $datosPaquete = Paquete::withTrashed()->where('Id', $paqueteContieneLote['IdPaquete'])->first();
        $infoPaquete = [
            'Id Lote' => $datosLote['Id'],
            'Id Paquete' => $datosPaquete['Id'],
            'Volumen(L)' => $datosPaquete['VolumenL'],
            'Peso(Kg)' => $datosPaquete['PesoKg'],
            'Almacen' => $datosAlmacen['Id'],
            'created_at' => $paqueteContieneLote['created_at'],
            'updated_at' => $paqueteContieneLote['updated_at'],
            'deleted_at' => $paqueteContieneLote['deleted_at']
        ];

        return $infoPaquete;
    }

    private function crearPaquete($paquete)
    {
        $paqueteContieneLote = new PaqueteContieneLote;
        $paqueteContieneLote->idLote = $paquete['idLote'];
        $paqueteContieneLote->idPaquete = $paquete['idPaquete'];
        $paqueteContieneLote->idAlmacen = $paquete['idAlmacen'];
        $paqueteContieneLote->save();
        $this->crearLote($paquete);
    }


    private function crearLote($paquete)
    {
        $valores = Paquete::withTrashed()->where('Id', $paquete['idPaquete'])->first();
        $lote = Lote::withTrashed()->where('Id', $paquete['idLote'])->first();
        $peso = $valores['PesoKg'] + $lote['PesoKg'];
        $volumen = $valores['VolumenL'] + $lote['VolumenL'];
        $lote->update([
            'VolumenL' => $volumen,
            'PesoKg' => $peso
        ]);
    }

    private function modificarValoresAntiguos($datosRequest)
    {
        $paqueteAntiguo = PaqueteContieneLote::where('IdPaquete', $datosRequest['identificador'])->first();
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
    }

    private function modificarValoresNuevos($datosRequest)
    {
        $valores = Paquete::withTrashed()->where('Id', $datosRequest['idPaquete'])->first();
        $lote = Lote::withTrashed()->where('Id', $datosRequest['idPaquete'])->first();
        $volumen = $lote['VolumenL'] + $valores['VolumenL'];
        $peso = $lote['PesoKg'] + $valores['PesoKg'];
        Lote::withTrashed()->where('Id', $datosRequest['idLote'])->update([
            'VolumenL' => $volumen,
            'PesoKg' => $peso
        ]);
    }

    private function eliminarPaqueteContieneLote($paqueteAntiguo, $id)
    {
        $valoresAntiguos = Paquete::withTrashed()->where('Id', $paqueteAntiguo['IdPaquete'])->first();
        $loteAntiguo = Lote::withTrashed()->where('Id', $paqueteAntiguo['IdLote'])->first();
        $volumen = $loteAntiguo['VolumenL'] - $valoresAntiguos['VolumenL'];
        $peso = $loteAntiguo['PesoKg'] - $valoresAntiguos['PesoKg'];
        Lote::withTrashed()->where('Id', $paqueteAntiguo['IdLote'])->update([
            'VolumenL' => $volumen,
            'PesoKg' => $peso
        ]);
        PaqueteContieneLote::where('IdPaquete', $id)->delete();
    }

    private function recuperarValoresPaquete($id)
    {
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

    }
}