<?php

namespace App\Http\Controllers;

use App\Models\Almacenes;
use App\Models\Lugares_Entrega;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class almacenController extends Controller
{

    public function cargarDatos()
    {
        $datosAlmacenes = [];
        $arrayAlmacenes = Almacenes::withTrashed()->get();
        foreach ($arrayAlmacenes as $almacen) {
            $datosAlmacenes[] = $this->obtenerDatosAlmacenes($almacen);
        }


        $datoLugarEntrega = Lugares_Entrega::withoutTrashed()->get();
        $idLugaresEntrega = [];
        $idLugaresEntrega = $this->definirIdsClase($datoLugarEntrega);
        Session::put('idLugaresEntrega', $idLugaresEntrega);
        Session::put('almacenes', $datosAlmacenes);
        return redirect()->route('backoffice.almacen');

    }
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
        return redirect()->route('backoffice.almacen');
    }

    public function agregar($datosRequest)
    { 
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            return;
        }
        $this->crearLugarAlmacen($datosRequest);
    }

    private function definirIdsClase($datoClase)
    {
        $datoId = [];
        foreach ($datoClase as $dato) {
            $datoId[] = $dato['id'];
        }
        return $datoId;
    }


    public function modificar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            return;
        }
        $this->modificarAlmacen($datosRequest);

    }

    public function eliminar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $almacen = Almacenes::withoutTrashed()->find($id);
        if ($almacen) {
            $almacen->delete();
        }
    }

    public function recuperar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $almacen = Almacenes::onlyTrashed()->find($id);
        if ($almacen) {
            $almacen->restore();
        }
    }

    private function obtenerDatosAlmacenes($almacen)
    {
        $lugarAlmacen = Lugares_Entrega::withTrashed()->where('id', $almacen['id_lugar_entrega'])->first();
        return [
            'Id Almacen' => $almacen['id'],
            'Id Lugar'=>$lugarAlmacen['id'],
            'Direccion Almacen' => $lugarAlmacen['direccion'],
            'Lat Almacen' => $lugarAlmacen['latitud'],
            'Lng Almacen' => $lugarAlmacen['longitud'],
            'created_at' => $almacen['created_at'],
            'updated_at' => $almacen['updated_at'],
            'deleted_at' => $almacen['deleted_at'],
        ];

    }

    private function validarDatos($almacen)
    {

        $reglas = [
            'lugar' => 'required|integer',
        ];
        return Validator::make([
            'lugar' => $almacen['idLugarEntrega'],
        ], $reglas);
    }

    private function crearLugarAlmacen($almacen)
    {
        $nuevaAlmacen = new Almacenes;
        $nuevaAlmacen->id_lugar_entrega = $almacen['idLugarEntrega'];
        $nuevaAlmacen->save();
    }

    private function modificarAlmacen($lugarAlmacen)
    {
        Almacenes::where('id', $lugarAlmacen['identificador'])->update([
            'id_lugar_entrega'=>$lugarAlmacen['idLugarEntrega']

        ]);
    }
}