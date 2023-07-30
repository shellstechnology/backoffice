<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\DireccionAlmacen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class almacenController extends Controller
{

    public function realizarAccion(Request $request)
    {
        $datosRequest = $request->all();
    
        if ($request->has('cbxAgregar')) {
            $this->agregar($datosRequest);
        } elseif ($request->has('cbxModificar')) {
            $this->modificar($datosRequest);
        } elseif ($request->has('cbxEliminar')) {
            $this->eliminar($datosRequest);
        }

        return view('vistaBackOfficeAlmacen');
    }
    
    public function cargarDatos()
    {
        $datosAlmacenes = [];
        $arrayAlmacenes = DireccionAlmacen::withTrashed()->get();
        foreach ($arrayAlmacenes as $almacen) {
            $datosAlmacenes[] = $this->obtenerDatosAlmacenes($almacen);
        }
        View::share('almacenes', $datosAlmacenes);
        return back();
    }

    public function agregar($datosRequest)
    { {
            try {
                $validador = $this->validarDatos($datosRequest);
                if ($validador->fails()) {
                    $errores = $validador->getMessageBag();
                    return response()->json(['error:' => $errores], 422);
                }
                $this->crearDireccionAlmacen($datosRequest);
            } catch (\Exception $e) {
                return response()->json(['Error al ingresar el almacen'], 500);
            }
        }
    }

    public function modificar($datosRequest)
    { {
            try {
                $validador = $this->validarDatos($datosRequest);
                if ($validador->fails()) {
                    $errores = $validador->getMessageBag();
                    return response()->json(['error:' => $errores], 422);
                }
                $this->modificarAlmacen($datosRequest);
            } catch (\Exception $e) {
                return response()->json(['Error al modificar el almacen'], 500);
            }
        }
    }

    public function eliminar($datosRequest)
    {
        $id = $datosRequest['identificador']; {
            try {
                DireccionAlmacen::where('Id', $id)->delete();
                Almacen::where('Id', $id)->delete();
            } catch (\Exception $e) {
                return response()->json(['Error al eliminar el almacen'], 500);
            }
        }
    }

    public function recuperar(Request $request)
    {
        $id = $request->get('identificador');
        $almacen = DireccionAlmacen::onlyTrashed()->find($id);
        if ($almacen) {
            try {
                DireccionAlmacen::where('Id', $id)->restore();
                Almacen::where('IdDireccionAlmacen', $id)->restore();
            } catch (\Exception $e) {
                return response()->json(['Error al restaurar el almacen'], 500);
            }
        } else {
            return response()->json(['El almacen no puede ser recuperado porque ya existe']);
        }
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
            'Direccion Almacen' => $almacen[0],
            'Lat Almacen' => $almacen['Latitud'],
            'Lng Almacen' => $almacen['Longitud'],
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
        DireccionAlmacen::where('Id', $direccionAlmacen[0])->update([
            'Direccion' => $direccionAlmacen['Direccion'],
            'Latitud' => $direccionAlmacen['Latitud'],
            'Longitud' => $direccionAlmacen['Longitud'],
        ]);

    }
}