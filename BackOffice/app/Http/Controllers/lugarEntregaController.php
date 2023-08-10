<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\DireccionAlmacen;
use App\Models\LugarEntrega;
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
        $datoAlmacen = Almacen::withTrashed()->get();
        $idAlmacen = [];
        $direccionAlmacen = DireccionAlmacen::withoutTrashed()->get();
        foreach ($datoAlmacen as $dato) {
            $infoLugarEntrega[] = $this->definirLugarEntrega($dato);
        }
        foreach ($direccionAlmacen as $datoDireccion) {
            $idAlmacen[] = $datoDireccion['Id'];
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
        $lugarEntregaEliminable = LugarEntrega::withoutTrashed()->find($id);
        if ($lugarEntregaEliminable) {
            LugarEntrega::where('Id', $id)->delete();
            Almacen::where('IdLugarDeEntrega',$id)->delete();
        }
    }

    public function recuperar($lugarEntrega)
    {
        $id = $lugarEntrega['identificador'];
        $lugarEntregaRestaurable = LugarEntrega::onlyTrashed()->find($id);
        if ($lugarEntregaRestaurable) {
            LugarEntrega::where('Id', $id)->restore();
            Almacen::where('IdLugarDerEntrega',$id)->restore();
        }
    }
    private function definirLugarEntrega($dato)
    {
        $direccionAlmacen = DireccionAlmacen::withTrashed()->where('Id', $dato['IdDireccionAlmacen'])->first();
        $lugarEntrega = LugarEntrega::withTrashed()->where('Id', $dato['IdLugarDeEntrega'])->first();
        if ($lugarEntrega && $direccionAlmacen) {
            return ($this->obtenerDatosLugaresEntrega($lugarEntrega, $direccionAlmacen));
        }
    }
    private function obtenerDatosLugaresEntrega($lugarEntrega, $direccionAlmacen)
    {
        return ([
            'Id Lugar' => $lugarEntrega['Id'],
            'Direccion Lugar' => $lugarEntrega['Direccion'],
            'Id Almacen' => $direccionAlmacen['Id'],
            'Direccion Almacen' => $direccionAlmacen['Direccion'],
            'Lat Lugar' => $lugarEntrega['Latitud'],
            'Lng Lugar' => $lugarEntrega['Longitud'],
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