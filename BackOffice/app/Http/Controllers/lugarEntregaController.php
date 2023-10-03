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
        try {
            $datosRequest = $request->all();
            switch ($request->has('accion')) {
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
            $this->cargarDatos();
            return redirect()->route('almacen.lugarEntrega');
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudo realizar la acción';
            Session::put('respuesta', $mensajeDeError);
        }
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
                return;
            }
            $this->crearLugarEntrega($datosRequest);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudo verificar los datos para agregar';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    public function verificarDatosModificar($lugarEntrega)
    {
        try {
            $validador = $this->validarDatos($lugarEntrega);
            if ($validador->fails()) {
                return;
            }
            $this->modificarLugarEntrega($lugarEntrega);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudieron verificar los datos para modificar';
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
            return redirect()->route('almacen.lugarEntrega');
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudo recuperar el lugar de entrega';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function obtenerDatosLugaresEntrega($lugarEntrega)
    {
        return ([
            'Id Lugar' => $lugarEntrega['id'],
            'Direccion Lugar' => $lugarEntrega['direccion'],
            'Lat Lugar' => $lugarEntrega['latitud'],
            'Lng Lugar' => $lugarEntrega['longitud'],
            'created_at' => $lugarEntrega['created_at'],
            'updated_at' => $lugarEntrega['updated_at'],
            'deleted_at' => $lugarEntrega['deleted_at'],
        ]);
    }

    private function validarDatos($lugarEntrega)
    {
        $reglas = [
            'direccionLugar' => 'required|string|max:100',
            'latitud' => 'required|numeric|min:-90|max:90',
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
        $lugarEntrega = new Lugares_Entrega;
        $lugarEntrega->direccion = $lugar['direccion'];
        $lugarEntrega->latitud = $lugar['latitud'];
        $lugarEntrega->longitud = $lugar['longitud'];
        $lugarEntrega->save();
    }

    private function modificarLugarEntrega($lugarEntrega)
    {
        Lugares_Entrega::where('id', $lugarEntrega['identificador'])->update([
            'direccion' => $lugarEntrega['direccion'],
            'latitud' => $lugarEntrega['latitud'],
            'longitud' => $lugarEntrega['longitud'],
        ]);
    }
}
