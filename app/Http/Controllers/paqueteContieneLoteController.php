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

        switch ($request->input('accion')) {
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
        };
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
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudieron cargar los datos';
            Session::put('respuesta', $mensajeDeError);
        }
        return redirect()->route('lote.paqueteContieneLote');
    }

    public function verificarDatosAgregar($datosRequest)
    {
        try {
            $validador = $this->validarDatos($datosRequest);
            if ($validador->fails()) {
                $errores = $validador->getMessageBag();
                Session::put('respuesta', json_encode($errores->messages()));
                return;
            }
            $paqueteExistente = Paquete_Contiene_Lote::where('id_paquete', $datosRequest['idPaquete'])->first();
            if (!$paqueteExistente) {
                $this->crearPaqueteContieneLote($datosRequest);
            }
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:Debe ingresar datos para realizar esta accion';
            Session::put('respuesta', $mensajeDeError);
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
                Session::put('respuesta', json_encode($errores->messages()));
                return;
            }
            $this->modificarValores($datosRequest);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:Debe ingresar datos para realizar esta accion';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    public function eliminarPaqueteContieneLote($datosRequest)
    {
        try {
            $id = $datosRequest['identificador'];
            $paqueteAntiguo = Paquete_Contiene_Lote::withoutTrashed()->where('id_paquete', $id)->first();
            if ($paqueteAntiguo) {
                $paqueteAntiguo->delete();
                $mensajeConfirmacion = 'Paquete en lote eliminado exitosamente';
                Session::put('respuesta', $mensajeConfirmacion);
            }
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: ';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    public function recuperarPaqueteContieneLote($datosRequest)
    {
        try {
            $id = $datosRequest['identificador'];
            $paqueteContieneLote = Paquete_Contiene_Lote::onlyTrashed()->where('id_paquete', $id)->first();
            if ($paqueteContieneLote) {
                $paqueteContieneLote->restore();
                $mensajeConfirmacion = 'Paquete en lote recuperado exitosamente';
                Session::put('respuesta', $mensajeConfirmacion);
            }
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:no se pudo recuperar el paquete ';
            Session::put('respuesta', $mensajeDeError);
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
            $mensajeDeError = 'Error:no se pudo obtener los datos de un paquete ';
            Session::put('respuesta', $mensajeDeError);
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
            $mensajeConfirmacion = 'Paquete agregado a lote exitosamente';
            Session::put('respuesta', $mensajeConfirmacion);
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudo agregar el paquete al lote';
            Session::put('respuesta', $mensajeDeError);
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
            $mensajeConfirmacion = 'Paquete en lote modificado exitosamente';
            Session::put('respuesta', $mensajeConfirmacion);
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudieron modificar los valores';
            Session::put('respuesta', $mensajeDeError);
        }
    }
}