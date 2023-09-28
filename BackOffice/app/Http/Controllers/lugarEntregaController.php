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
        if ($request->has('cbxAgregar')) {
            $this->verificarDatosAgregar($datosRequest);
        }
        if ($request->has('cbxModificar')) {
            $this->verificarDatosModificar($datosRequest);
        }
        if ($request->has('cbxEliminar')) {
            $this->eliminarLugarEntrega($datosRequest);
        }
        if ($request->has('cbxRecuperar')) {
            $this->recuperarLugarEntrega($datosRequest);
        }
        $this->cargarDatos();
        return redirect()->route('almacen.lugarEntrega');
    }
    public function cargarDatos()
    {
        $infoLugarEntrega = [];
        $listaLugares=Lugares_Entrega::withTrashed()->get();
        foreach ($listaLugares as $dato) {
            $infoLugarEntrega[] = $this->obtenerDatosLugaresEntrega($dato);
        }

        Session::put('lugaresEntrega', $infoLugarEntrega);
        return redirect()->route('almacen.lugarEntrega');
    }

    public function verificarDatosAgregar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            return;
        }
        $this->crearLugarEntrega($datosRequest);
    }


    public function verificarDatosModificar($lugarEntrega)
    {
        $validador = $this->validarDatos($lugarEntrega);
        if ($validador->fails()) {
            return;
        }
        $this->modificarLugarEntrega($lugarEntrega);
    }


    public function eliminarLugarEntrega($lugarEntrega)
    {
        $id = $lugarEntrega['identificador'];
        $lugarEntregaEliminable = Lugares_Entrega::withoutTrashed()->find($id);
        if ($lugarEntregaEliminable) {
          $lugarEntregaEliminable->delete();
        }
    }

    public function recuperarLugarEntrega($lugarEntrega)
    {
        $id = $lugarEntrega['identificador'];
        $lugarEntregaRestaurable = Lugares_Entrega::onlyTrashed()->find($id);
        if ($lugarEntregaRestaurable) {
            $lugarEntregaRestaurable->restore();
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
        $lugarEntrega->Direccion = $lugar['direccion'];
        $lugarEntrega->Latitud = $lugar['latitud'];
        $lugarEntrega->Longitud = $lugar['longitud'];
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