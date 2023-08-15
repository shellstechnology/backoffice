<?php

namespace App\Http\Controllers;

use App\Models\Almacenes;
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
        return redirect()->route('almacen.lugarEntrega');
    }
    public function cargarDatos()
    {
        $infoLugarEntrega = [];
        $almacenes = Almacenes::withTrashed()->get();
        $idAlmacen = [];
        foreach ($almacenes as $dato) {
            $infoLugarEntrega[] = $this->definirLugarEntrega($dato);
        }
        Session::put('idAlmacenes', $idAlmacen);
        Session::put('lugaresEntrega', $infoLugarEntrega);
        return redirect()->route('almacen.lugarEntrega');
    }

    public function agregar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            $errores = $validador->getMessageBag();
            return response()->json(['error:' => $errores], 422);
        }
        $this->crearLugarEntrega($datosRequest);
    }


    public function modificar($lugarEntrega)
    {
        $validador = $this->validarDatos($lugarEntrega);
        if ($validador->fails()) {
            $errores = $validador->getMessageBag();
            return response()->json(['error:' => $errores], 422);
        }
        $this->modificarLugarEntrega($lugarEntrega);
    }


    public function eliminar($lugarEntrega)
    {
        $id = $lugarEntrega['identificador'];
        $lugarEntregaEliminable = Lugares_Entrega::withoutTrashed()->find($id);
        if ($lugarEntregaEliminable) {
          $lugarEntregaEliminable->delete();
            Almacenes::where('id_lugar_entrega',$id)->delete();
        }
    }

    public function recuperar($lugarEntrega)
    {
        $id = $lugarEntrega['identificador'];
        $lugarEntregaRestaurable = Lugares_Entrega::onlyTrashed()->find($id);
        if ($lugarEntregaRestaurable) {
            $lugarEntregaRestaurable->restore();
            Almacenes::where('id_lugar_entrega',$id)->restore();
        }
    }
    private function definirLugarEntrega($dato)
    {
        $lugarEntrega = Lugares_Entrega::withTrashed()->where('Id', $dato['id_lugar_entrega'])->first();
        if ($lugarEntrega) {
            return ($this->obtenerDatosLugaresEntrega($lugarEntrega));
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
            'Direccion Lugar' => 'required|string|max:25',
            'Lat Lugar' => 'required|numeric|min:-90|max:90',
            'Lng Lugar' => 'required|numeric|min:-180|max:180'
        ];
        return Validator::make([
            'Direccion Lugar' => $lugarEntrega['direccion'],
            'Lat Lugar' => $lugarEntrega['latitud'],
            'Lng Lugar' => $lugarEntrega['longitud'],
        ], $reglas);
    }

    private function crearLugarEntrega($lugar)
    {

        $lugarEntrega = new LugarEntrega;
        $lugarEntrega->Direccion = $lugar['direccion'];
        $lugarEntrega->Latitud = $lugar['latitud'];
        $lugarEntrega->Longitud = $lugar['longitud'];
        $lugarEntrega->save();
        $almacen = new Almacen;
        $almacen->IdDireccionAlmacen = $lugar['idAlmacen'];
        $almacen->IdLugarDeEntrega = $lugarEntrega->id;
        $almacen->save();
    }

    private function modificarLugarEntrega($lugarEntrega)
    {
        LugarEntrega::where('Id', $lugarEntrega['identificador'])->update([
            'Direccion' => $lugarEntrega['direccion'],
            'Latitud' => $lugarEntrega['latitud'],
            'Longitud' => $lugarEntrega['longitud'],
        ]);
        $this->modificarAlmacen($lugarEntrega);
    }

    private function modificarAlmacen($lugarEntrega)
    {
        Almacen::where('IdLugarDeEntrega', $lugarEntrega['identificador'])->update([
            'IdDireccionAlmacen' => $lugarEntrega['idAlmacen'],
        ]);
    }
}