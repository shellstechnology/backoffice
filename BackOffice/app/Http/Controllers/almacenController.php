<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\DireccionAlmacen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class almacenController extends Controller
{

    public function cargarDatos()
    {
        $datosAlmacenes = [];
        $arrayAlmacenes = DireccionAlmacen::withTrashed()->get();
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
        $id = $datosRequest['identificador']; {
            DireccionAlmacen::where('Id', $id)->delete();
            Almacen::where('Id', $id)->delete();
        }
    }

    public function recuperar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $almacen = DireccionAlmacen::onlyTrashed()->find($id);
        if ($almacen) {
            DireccionAlmacen::where('Id', $id)->restore();
            Almacen::where('IdDireccionAlmacen', $id)->restore();
        }
        return redirect()->route('backoffice.almacen');
    }

    private function obtenerDatosAlmacenes($almacen)
    {
        return [
            'Id Almacen' => $almacen['Id'],
            'Direccion Almacen' => $almacen['Direccion'],
            'Lat Almacen' => $almacen['Latitud'],
            'Lng Almacen' => $almacen['Longitud'],
            'created_at' => $almacen['created_at'],
            'updated_at' => $almacen['updated_at'],
            'deleted_at' => $almacen['deleted_at'],
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
        $this->crearAlmacen($direccionAlmacen);
    }

    private function crearAlmacen($direccionAlmacen)
    {
        $almacen = new Almacen;
        $almacen->IdDireccionAlmacen = $direccionAlmacen->getKey();
        $almacen->save();
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

