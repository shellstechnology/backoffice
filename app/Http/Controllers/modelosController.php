<?php

namespace App\Http\Controllers;

use App\Models\marcas;
use App\Models\modelos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class modelosController extends Controller
{
    public function realizarAccion(Request $request)
    {
        $datosRequest = $request->all();
        switch ($request->input('accion')) {
            case 'agregar':
                $this->verificarDatosAAgregar($datosRequest);
                break;
            case 'modificar':
                $this->verificarDatosAModificar($datosRequest);
                break;
            case 'eliminar':
                $this->eliminarModelo($datosRequest);
                break;
            case 'recuperar':
                $this->recuperarModelo($datosRequest);
                break;
        }
        return redirect()->route('marca.modelo');
    }
    public function cargarDatos()
    { {
            try {
                $datosModelos = [];
                $arrayModelos = Modelos::withTrashed()->get();
                foreach ($arrayModelos as $modelo) {
                    $datosModelos[] = $this->obtenerDatosModelos($modelo);
                }
                $datoMarcas = Marcas::withoutTrashed()->get();
                $arrayMarcas = [];
                $arrayMarcas = $this->obtenerMarcas($datoMarcas);
                Session::put('listaMarcas', $arrayMarcas);
                Session::put('modelo', $datosModelos);
            } catch (\Exception $e) {
                $mensajeDeError = 'Error,no se pudieron cargar los datos';
                Session::put('respuesta', $mensajeDeError);
            }
            return redirect()->route('marca.modelo');
            
        }
    }

    public function verificarDatosAAgregar($datosRequest)
    { {
            try {
                $validador = $this->validarDatos($datosRequest);
                if ($validador->fails()) {
                    $errores = $validador->getMessageBag();
                    Session::put('respuesta', json_encode($errores->messages()));
                    return;
                }
                $this->crearModelo($datosRequest);
            } catch (\Exception $e) {
                $mensajeDeError = 'Error:Debe ingresar datos para realizar esta accion';
                Session::put('respuesta', $mensajeDeError);
            }
        }
        return redirect()->route('marca.modelo');
    }

    private function obtenerMarcas($marca)
    { {
            try {
                $arrayMarca = [];
                foreach ($marca as $dato) {
                    $arrayMarca[] = $dato['marca'];
                }
                return $arrayMarca;
            } catch (\Exception $e) {
                $mensajeDeError = 'Error:no se pudieron cargar los datos:No se pudo obtener los datos de un lugar entrega ';
                Session::put('respuesta', $mensajeDeError);
            }
        }
    }


    public function verificarDatosAModificar($datosRequest)
    {
        try {
            $validador = $this->validarDatos($datosRequest);
            if ($validador->fails()) {
                $errores = $validador->getMessageBag();
                Session::put('respuesta', json_encode($errores->messages()));
                return;
            }
            $this->modificarModelo($datosRequest);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:Debe ingresar datos para realizar esta accion';
            Session::put('respuesta', $mensajeDeError);
        }
        return redirect()->route('marca.modelo');

    }

    public function eliminarModelo($datosRequest)
    { {
            try {
                $id = $datosRequest['identificador'];
                $modelo = Modelos::withoutTrashed()->find($id);
                if ($modelo) {
                    $modelo->delete();
                }
                $mensajeConfirmacion = 'Modelo eliminado exitosamente';
                Session::put('respuesta', $mensajeConfirmacion);
                $this->cargarDatos();
            } catch (\Exception) {
                $mensajeDeError = 'Error,no se pudo eliminar el almacen';
                Session::put('respuesta', $mensajeDeError);
            }
            return redirect()->route('marca.modelo');
        }
    }

    public function recuperarModelo($datosRequest)
    { {
            try {
                $id = $datosRequest['identificador'];
                $modelo = Modelos::onlyTrashed()->find($id);
                if ($modelo) {
                    $modelo->restore();
                }
                $mensajeConfirmacion = 'Modelos restaurado exitosamente';
                Session::put('respuesta', $mensajeConfirmacion);
                $this->cargarDatos();

            } catch (\Exception $e) {
                $mensajeDeError = 'Error:no se pudo restaurar el almacen';
                Session::put('respuesta', $mensajeDeError);
            }
            return redirect()->route('marca.modelo');
        }
    }

    private function obtenerDatosModelos($modelo)
    { {
            try {
                $marca = Marcas::withTrashed()->where('id', $modelo['id_marca'])->first();
                return [
                    'Id' => $modelo['id'],
                    'Modelo' => $modelo['modelo'],
                    'Marca' => $marca['marca'],
                    'created_at' => $modelo['created_at'],
                    'updated_at' => $modelo['updated_at'],
                    'deleted_at' => $modelo['deleted_at'],
                ];
            } catch (\Exception) {
                $mensajeDeError = 'Error: No se pudieron cargar los datos del modelo ' . $modelo['id'];
                Session::put('respuesta', $mensajeDeError);
            }
        }
    }

    private function validarDatos($modelo)
    {
        $reglas = [
            'modelo' => 'required|string|max:50',
            'marca' => 'required|string|max:50'
        ];
        return Validator::make([
            'modelo' => $modelo['modelo'],
            'marca' => $modelo['marcaCamion'],
        ], $reglas);

    }

    private function crearModelo($modelo)
    { {
            try {
                $marca=$this->obtenerIdMarca($modelo['marcaCamion']);
                $nuevoModelo = new Modelos;
                $nuevoModelo->modelo = $modelo['modelo'];
                $nuevoModelo->id_marca = $marca;
                $nuevoModelo->save();
                $mensajeConfirmacion = 'Modelo creado exitosamente';
                Session::put('respuesta', $mensajeConfirmacion);
                $this->cargarDatos();
            } catch (\Exception $e) {
                $mensajeDeError = 'Error:no se pudo crear el modelo';
                Session::put('respuesta', $mensajeDeError);
            }
        }
        return redirect()->route('marca.modelo');
    }
    private function obtenerIdMarca($marcaModelo){
        try{
        $marca=Marcas::withTrashed()->where('marca',$marcaModelo)->first();
        return $marca['id'];
        }catch(\Exception $e){
            
        }
    }
    private function modificarModelo($modelo)
    { {
            try {
                $marca=$this->obtenerIdMarca($modelo['marcaCamion']);
                Modelos::where('id', $modelo['identificador'])->update([
                    'modelo' => $modelo['modelo'],
                    'id_marca'=>$marca
                ]);
                $mensajeConfirmacion = 'Modelo modificado exitosamente';
                Session::put('respuesta', $mensajeConfirmacion);
                $this->cargarDatos();
            } catch (\Exception $e) {
                $mensajeDeError = 'Error:no se pudo modificar el almacen';
                Session::put('respuesta', $mensajeDeError);
            }
        }
        return redirect()->route('marca.modelo');
    }
}
