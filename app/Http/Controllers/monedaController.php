<?php

namespace App\Http\Controllers;

use App\Models\moneda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class monedaController extends Controller
{
    public function realizarAccion(Request $request)
    {
        try {
            $datosRequest = $request->all();
            $accion=$request->input('accion');
            if($accion=="agregar")
            $this->verificarDatosAgregar($datosRequest);
            
            if($accion=="modificar")
            $this->verificarDatosModificar($datosRequest);
    
            if($accion=="eliminar")
            $this->eliminarMoneda($datosRequest);
    
            if($accion=="recuperar")
            $this->recuperarMoneda($datosRequest);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error,no se pudo  procesar la accion';
            Session::put('respuesta', $mensajeDeError);
        }
        return redirect()->route('backoffice.moneda');
    }
    public function cargarDatos()
    {
        try {
            $datoMoneda = Moneda::withTrashed()->get();
            $infoMoneda = [];
            if ($datoMoneda) {
                foreach ($datoMoneda as $dato) {
                    $infoMoneda[] = $this->obtenerMoneda($dato);
                }
            }
            Session::put('datosMonedas', $infoMoneda);
            return redirect()->route('backoffice.moneda');
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:No se pudo cargar los datos';
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
            $this->crearMoneda($datosRequest);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:Debe ingresar datos para realizar esta accion';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    public function verificarDatosModificar($datosRequest)
    {
        try {
            $validador = $this->validarDatos($datosRequest);
            if ($validador->fails()) {
                $errores = $validador->getMessageBag();
                Session::put('respuesta', json_encode($errores->messages()));
                return;
            }
            $this->modificarMoneda($datosRequest);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:Debe ingresar datos para realizar esta accion';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    public function eliminarMoneda($datosRequest)
    {
        try {
            $moneda = Moneda::withoutTrashed()->where('id', $datosRequest['identificador'])->first();
            if ($moneda) {
                $moneda->delete();
                $mensajeConfirmacion = 'Moneda eliminada exitosamente';
                Session::put('respuesta', $mensajeConfirmacion);
            }
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:No se pudo eliminar esta moneda';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    public function recuperarMoneda($datosRequest)
    {
        try {
            $moneda = Moneda::onlyTrashed()->where('id', $datosRequest['identificador'])->first();
            if ($moneda) {
                $moneda->restore();
                $mensajeConfirmacion = 'Moneda recuperada exitosamente';
                Session::put('respuesta', $mensajeConfirmacion);
            }
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:No se pudo recuperar esta moneda';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function obtenerMoneda($moneda)
    {
        try {
            return ([
                'Id' => $moneda['id'],
                'Nombre' => $moneda['moneda'],
                'created_at' => $moneda['created_at'],
                'updated_at' => $moneda['updated_at'],
                'deleted_at' => $moneda['deleted_at']
            ]);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:No se pudo obtener los datos de una o mas monedas';
            Session::put('respuesta', $mensajeDeError);
        }

    }

    private function obtenerMonedas()
    {
        try {
            $infoMonedas = [];
            $monedas = moneda::withTrashed()->get();
            if ($monedas) {
                foreach ($monedas as $datoMoneda) {
                    $infoMonedas[] = $datoMoneda['moneda'];
                }
            }
            return $infoMonedas;
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:Ocurrio un error al intentar acceder a los datos de la base de datos';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function validarDatos($moneda)
    {
        $reglas = [
            'Nombre' => 'required|string|max:20',
        ];
        return Validator::make([
            'Nombre' => $moneda['nombre'],
        ], $reglas);
    }

    private function crearMoneda($moneda)
    {
        try {
            $nuevaMoneda = new Moneda;
            $nuevaMoneda->moneda = $moneda['nombre'];
            $nuevaMoneda->save();
            $mensajeConfirmacion = 'Moneda creada exitosamente';
            Session::put('respuesta', $mensajeConfirmacion);
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:No se pudo crear esta moneda';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function modificarMoneda($moneda)
    {
        try {
            Moneda::where('id', $moneda['identificador'])->update([
                'moneda' => $moneda['nombre'],
            ]);
            $mensajeConfirmacion = 'Moneda modificada exitosamente';
            Session::put('respuesta', $mensajeConfirmacion);
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:No se pudo modificar esta moneda';
            Session::put('respuesta', $mensajeDeError);
        }
    }
}
