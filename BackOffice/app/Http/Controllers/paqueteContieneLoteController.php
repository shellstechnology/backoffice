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

        switch ($request->has('accion')) {
            case 'agregar':
                $this->verificarDatosAgregar($datosRequest);
                break;
            case 'modificar':
                $this->verificarDatosModificar($datosRequest);
                break;
            case 'eliminar':
                $this->eliminarPaqueteContieneLote($datosRequest);
                break;
            case 'recuperar':
                $this->recuperarPaqueteContieneLote($datosRequest);
                break;
        }
        ;
        $this->cargarDatos();
        return redirect()->route('lote.paqueteContieneLote');
    }
    public function cargarDatos()
    {
        try {
            $datosPaqueteContieneLote = Paquete_Contiene_Lote::withTrashed()->get();
            $infoPaqueteContieneLote = [];
            $idAlmacen = [];
            $idPaquete = [];
            $idLote = [];
            foreach ($datosPaqueteContieneLote as $paqueteContieneLote) {
                $infoPaqueteContieneLote[] = $this->obtenerPaquete($paqueteContieneLote);
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
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
    }

    public function verificarDatosAgregar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            $errores = $validador->getMessageBag();
            $patron = '"';
            $resultado = str_replace($patron, '', json_encode($errores->messages()));
            Session::put('respuesta', $resultado);
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
            'idPaquete' => 'required|integer',
            'idLote' => 'required|integer',
            'idAlmacen' => 'required|integer',
        ];
        return Validator::make([
            'idPaquete' => $producto['idPaquete'],
            'idLote' => $producto['idLote'],
            'idAlmacen' => $producto['idAlmacen'],
        ], $reglas);
    }

    public function verificarDatosModificar($datosRequest)
    {
        try {
            $validador = $this->validarDatos($datosRequest);
            if ($validador->fails()) {
                $errores = $validador->getMessageBag();
                $patron = '"';
                $resultado = str_replace($patron, '', json_encode($errores->messages()));
                Session::put('respuesta', $resultado);
                return;
            }
            $this->modificarValores($datosRequest);
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
    }

    public function eliminarPaqueteContieneLote($datosRequest)
    {
        try {
            $id = $datosRequest['identificador'];
            $paqueteAntiguo = Paquete_Contiene_Lote::withoutTrashed()->where('id_paquete', $id)->first();
            if ($paqueteAntiguo) {
                $paqueteAntiguo->delete();
            }
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
    }

    public function recuperarPaqueteContieneLote($datosRequest)
    {
        try {
            $id = $datosRequest['identificador'];
            $paqueteContieneLote = Paquete_Contiene_Lote::onlyTrashed()->where('id_paquete', $id)->first();

            if ($paqueteContieneLote) {
                $paqueteContieneLote->restore();
            }
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
    }

    private function obtenerPaquete($paqueteContieneLote)
    {
        try {
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
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
    }

    private function crearPaqueteContieneLote($paquete)
    {
        try {
            $paqueteContieneLote = new Paquete_Contiene_Lote;
            $paqueteContieneLote->id_paquete = $paquete['idPaquete'];
            $paqueteContieneLote->id_lote = $paquete['idLote'];
            $paqueteContieneLote->id_almacen = $paquete['idAlmacen'];
            $paqueteContieneLote->save();
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
    }


    private function actualizarLote($paquete)
    {
        try {
            $valores = Paquetes::withTrashed()->where('id', $paquete['idPaquete'])->first();
            $lote = Lotes::withTrashed()->where('id', $paquete['idLote'])->first();
            $peso = $valores['peso_kg'] + $lote['peso_kg'];
            $volumen = $valores['volumen_l'] + $lote['volumen_l'];
            Lotes::withTrashed()->where('id', $paquete['idLote'])->update([
                'peso_kg' => $peso,
                'volumen_l' => $volumen,

            ]);
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
    }

    private function modificarValores($datosRequest)
    {
        try {
            Paquete_Contiene_Lote::where('id_paquete', $datosRequest['identificador'])->update([
                'id_lote' => $datosRequest['idLote'],
                'id_paquete' => $datosRequest['idPaquete'],
                'id_almacen' => $datosRequest['idAlmacen'],
            ]);
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
    }
}