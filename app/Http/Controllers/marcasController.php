<?php

namespace App\Http\Controllers;

use App\Models\marcas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class marcasController extends Controller
{
    public function realizarAccion(Request $request)
    {
        $datosRequest = $request->all();
        switch ($request->input('accion')) {
            case 'agregar':
                $this->verificarDatosAgregar($datosRequest);
                break;
            case 'modificar':
                $this->verificarDatosModificar($datosRequest);
                break;
            case 'eliminar':
                $this->eliminarMarca($datosRequest);
                break;
            case 'recuperar':
                $this->recuperarMarca($datosRequest);
                break;
        };
        return redirect()->route('backoffice.marca');
    }
    public function cargarDatos()
    {
        try{
            $datoMarca = Marcas::withTrashed()->get();
            $infoMarca = [];
            if ($datoMarca) {
                foreach ($datoMarca as $dato) {
                    $infoMarca[] = $this->obtenerMarca($dato);
                }
            }
            Session::put('marca', $infoMarca);
            return redirect()->route('backoffice.marca');
        } catch (\Exception $e){
            $mensajeDeError = 'Error: ';
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
            $this->crearMarca($datosRequest);
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
            $this->modificarMarca($datosRequest);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:Debe ingresar datos para realizar esta accion';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    public function eliminarMarca($datosRequest)
    {
        try{
            $marca = Marcas::withoutTrashed()->where('id', $datosRequest['identificador'])->first();
            if ($marca) {
                $marca->delete();
                $mensajeConfirmacion = 'Marca eliminada exitosamente';
                Session::put('respuesta', $mensajeConfirmacion);
            }
            $this->cargarDatos();
        } catch (\Exception $e){
            $mensajeDeError = 'Error: ';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    public function recuperarMarca($datosRequest)
    {
        try{
            $marca = Marcas::onlyTrashed()->where('id', $datosRequest['identificador'])->first();
            if ($marca) {
                $marca->restore();
                $mensajeConfirmacion = 'Marca recuperada exitosamente';
                Session::put('respuesta', $mensajeConfirmacion);
            }
            $this->cargarDatos();
        }catch (\Exception $e){
            $mensajeDeError = 'Error: ';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function obtenerMarca($marca)
    {
        try {
            return ([
                'Id' => $marca['id'],
                'Marca' => $marca['marca'],
                'created_at' => $marca['created_at'],
                'updated_at' => $marca['updated_at'],
                'deleted_at' => $marca['deleted_at']
            ]);
        } catch (\Exception $e){
            $mensajeDeError = 'Error: ';
            Session::put('respuesta', $mensajeDeError);
        }

    }

    private function validarDatos($producto)
    {
        $reglas = [
            'Marca' => 'required|string|max:50',
        ];
        return Validator::make([
            'Marca' => $producto['marca'],
        ], $reglas);
    }

    private function crearMarca($marca)
    {
        try {
            $nuevaMarca = new Marcas;
            $nuevaMarca->marca = $marca['marca'];
            $nuevaMarca->save();
            $mensajeConfirmacion = 'Marca creada exitosamente';
            Session::put('respuesta', $mensajeConfirmacion);
            $this->cargarDatos();
        } catch (\Exception $e){
            $mensajeDeError = 'Error: ';
            Session::put('respuesta', $mensajeDeError);
        }
    }
    private function modificarMarca($producto)
    {
        try{
            Marcas::where('id', $producto['identificador'])->update([
                'marca' => $producto['marca'],
            ]);
            $mensajeConfirmacion = 'Marca modificada exitosamente';
            Session::put('respuesta', $mensajeConfirmacion);
            $this->cargarDatos();
        } catch (\Exception $e){
            $mensajeDeError = 'Error: ';
            Session::put('respuesta', $mensajeDeError);
        }
    }
}
