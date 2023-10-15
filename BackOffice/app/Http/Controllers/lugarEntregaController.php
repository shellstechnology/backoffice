<?php

namespace App\Http\Controllers;

use App\Models\Lugares_Entrega;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class lugarEntregaController extends Controller
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
                $this->eliminarLugarEntrega($datosRequest);
                break;
            case 'recuperar':
                $this->recuperarLugarEntrega($datosRequest);
                break;
        }
        return redirect()->route('almacen.lugarEntrega');
    }

    public function cargarDatos()
    {
        try {
            $infoLugarEntrega = [];
            $listaLugares = Lugares_Entrega::withTrashed()->get();
            foreach ($listaLugares as $dato) {
                $infoLugarEntrega[] = $this->obtenerDatosLugaresEntrega($dato);
            }

            Session::put('lugaresEntrega', $infoLugarEntrega);
            return redirect()->route('almacen.lugarEntrega');
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudieron cargar los datos';
            Session::put('respuesta', $mensajeDeError);
        }
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
            $this->crearLugarEntrega($datosRequest);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:Debe ingresar datos para realizar esta accion';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    public function verificarDatosModificar($lugarEntrega)
    {
        try {
            $validador = $this->validarDatos($lugarEntrega);
            if ($validador->fails()) {
                $errores = $validador->getMessageBag();
                Session::put('respuesta', json_encode($errores->messages()));
                return;
            }
            $this->modificarLugarEntrega($lugarEntrega);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:Debe ingresar datos para realizar esta accion';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    public function eliminarLugarEntrega($lugarEntrega)
    {
        try {
            $id = $lugarEntrega['identificador'];
            $lugarEntregaEliminable = Lugares_Entrega::withoutTrashed()->find($id);
            if ($lugarEntregaEliminable) {
                $lugarEntregaEliminable->delete();
            }
            $mensajeConfirmacion = 'Lugar de entrega eliminado exitosamente';
            Session::put('respuesta', $mensajeConfirmacion);
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudo eliminar el lugar de entrega';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    public function recuperarLugarEntrega($lugarEntrega)
    {
        try {
            $id = $lugarEntrega['identificador'];
            $lugarEntregaRestaurable = Lugares_Entrega::onlyTrashed()->find($id);
            if ($lugarEntregaRestaurable) {
                $lugarEntregaRestaurable->restore();
            }
            $mensajeConfirmacion = 'Lugar de entrega recuperado exitosamente';
            Session::put('respuesta', $mensajeConfirmacion);
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudo recuperar el lugar de entrega';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function obtenerDatosLugaresEntrega($lugarEntrega)
    {
        try {
            return ([
                'Id Lugar' => $lugarEntrega['id'],
                'Direccion Lugar' => $lugarEntrega['direccion'],
                'Lat Lugar' => $lugarEntrega['latitud'],
                'Lng Lugar' => $lugarEntrega['longitud'],
                'created_at' => $lugarEntrega['created_at'],
                'updated_at' => $lugarEntrega['updated_at'],
                'deleted_at' => $lugarEntrega['deleted_at'],
            ]);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudieron obtener los datos de un lugar de entrega';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function validarDatos($lugarEntrega)
    {
        $reglas = [
            'direccionLugar' => 'required|string|max:100',
            'latitud' => 'required|numeric|min:-180|max:180',
            'longitud' => 'required|numeric|min:-180|max:180'
        ];
        return Validator::make([
            'direccionLugar' => $lugarEntrega['direccion'],
            'latitud' => $lugarEntrega['latitud'],
            'longitud' => $lugarEntrega['longitud'],
        ], $reglas);
    }

    private function crearLugarEntrega($lugar)
    {
        try {
            $lugarEntrega = new Lugares_Entrega;
            $lugarEntrega->direccion = $lugar['direccion'];
            $lugarEntrega->latitud = $lugar['latitud'];
            $lugarEntrega->longitud = $lugar['longitud'];
            $lugarEntrega->save();
            $mensajeConfirmacion = 'Lugar de entrega creado exitosamente';
            Session::put('respuesta', $mensajeConfirmacion);
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudo crear el lugar de entrega';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function modificarLugarEntrega($lugarEntrega)
    {
        try {
            Lugares_Entrega::where('id', $lugarEntrega['identificador'])->update([
                'direccion' => $lugarEntrega['direccion'],
                'latitud' => $lugarEntrega['latitud'],
                'longitud' => $lugarEntrega['longitud'],
            ]);
            $mensajeConfirmacion = 'Lugar de entrega modificado exitosamente';
            Session::put('respuesta', $mensajeConfirmacion);
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudo modificar el lugar de entrega';
            Session::put('respuesta', $mensajeDeError);
        }
    }
}