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
            $errores = $validador->getMessageBag();
            return response()->json(['error:' => $errores], 422);
        }
        $this->crearLugarAlmacen($datosRequest);
    }

    public function modificar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            $errores = $validador->getMessageBag();
            return response()->json(['error:' => $errores], 422);
        }
        $this->modificarAlmacen($datosRequest);

    }

    public function eliminar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $almacen = Lugares_Entrega::withoutTrashed()->find($id);
        if ($almacen) {
            $almacen->delete();
        }
    }

    public function recuperar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $almacen = Lugares_Entrega::onlyTrashed()->find($id);
        if ($almacen) {
           $almacen->restore();
        }
        return redirect()->route('backoffice.almacen');
    }

    private function obtenerDatosAlmacenes($almacen)
    {
        $lugarAlmacen=Lugares_Entrega::withTrashed()->where('id',$almacen['id_lugar_entrega'])->first();
        return [
            'Id Almacen' => $almacen['id'],
            'Direccion Almacen' => $lugarAlmacen['direccion'],
            'Lat Almacen' => $lugarAlmacen['latitud'],
            'Lng Almacen' => $lugarAlmacen['longitud'],
            'created_at' => $lugarAlmacen['created_at'],
            'updated_at' => $lugarAlmacen['updated_at'],
            'deleted_at' => $lugarAlmacen['deleted_at'],
        ];

    }

    private function validarDatos($almacen)
    {

        $reglas = [
            'Direccion Almacen' => 'required|string|max:25',
            'Lat Almacen' => 'required|numeric|min:-90|max:90',
            'Lng Almacen' => 'required|numeric|min:-180|max:180'
        ];
        return Validator::make([
            'Direccion Almacen' => $almacen['direccion'],
            'Lat Almacen' => $almacen['latitud'],
            'Lng Almacen' => $almacen['longitud'],
        ], $reglas);
    }

    private function crearLugarAlmacen($almacen)
    {
        $lugarAlmacen = new Lugares_Entrega;
        $lugarAlmacen->direccion = $almacen['direccion'];
        $lugarAlmacen->latitud = $almacen['latitud'];
        $lugarAlmacen->longitud = $almacen['longitud'];
        $lugarAlmacen->save();
        $nuevaAlmacen=new Almacenes;
        $nuevaAlmacen->id_lugar_entrega=$lugarAlmacen->id;
        $nuevaAlmacen->save();
    }

    private function modificarAlmacen($lugarAlmacen)
    {
        Lugares_Entrega::where('id', $lugarAlmacen['identificador'])->update([
            'direccion' => $lugarAlmacen['direccion'],
            'latitud' => $lugarAlmacen['latitud'],
            'longitud' => $lugarAlmacen['longitud'],
        ]);
    }
}