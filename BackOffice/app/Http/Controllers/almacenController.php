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
        $this->crearDireccionAlmacen($datosRequest);
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
        $almacen = DireccionAlmacen::withoutTrashed()->find($id);
        if ($almacen) {
            DireccionAlmacen::where('Id', $id)->delete();
        }
    }

    public function recuperar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $almacen = DireccionAlmacen::onlyTrashed()->find($id);
        if ($almacen) {
            DireccionAlmacen::where('Id', $id)->restore();
        }
        return redirect()->route('backoffice.almacen');
    }

    private function obtenerDatosAlmacenes($almacen)
    {
        $lugarAlmacen=Lugares_Entrega::withTrashed()->where('id',$almacen['id_lugar_entrega'])->first();
        return [
            'Id Almacen' => $lugarAlmacen['id'],
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

    private function crearDireccionAlmacen($almacen)
    {
        $direccionAlmacen = new DireccionAlmacen;
        $direccionAlmacen->Direccion = $almacen['direccion'];
        $direccionAlmacen->Latitud = $almacen['latitud'];
        $direccionAlmacen->Longitud = $almacen['longitud'];
        $direccionAlmacen->save();
    }

    private function modificarAlmacen($direccionAlmacen)
    {
        DireccionAlmacen::where('Id', $direccionAlmacen['identificador'])->update([
            'Direccion' => $direccionAlmacen['direccion'],
            'Latitud' => $direccionAlmacen['latitud'],
            'Longitud' => $direccionAlmacen['longitud'],
        ]);

    }
}