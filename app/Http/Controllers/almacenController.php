<?php

namespace App\Http\Controllers;

use App\Models\almacenes;
use App\Models\lugares_entrega;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class almacenController extends Controller
{

    public function cargarDatos()
    { {
            try {
                $datosAlmacenes = [];
                $arrayAlmacenes = Almacenes::withTrashed()->get();
                foreach ($arrayAlmacenes as $almacen) {
                    $datosAlmacenes[] = $this->obtenerDatosAlmacenes($almacen);
                }
                $datoLugarEntrega = Lugares_Entrega::withoutTrashed()->get();
                $idLugaresEntrega = [];
                $idLugaresEntrega = $this->obtenerIdsClase($datoLugarEntrega);
                Session::put('idLugaresEntrega', $idLugaresEntrega);
                Session::put('almacenes', $datosAlmacenes);
            } catch (\Exception $e) {
                $mensajeDeError = 'Error,no se pudieron cargar los datos';
                Session::put('respuesta', $mensajeDeError);
            }
            return redirect()->route('backoffice.almacen');
        }
    }

    public function realizarAccion(Request $request)
    {
        try {
            $datosRequest = $request->all();
            $accion=$request->input('accion');
            if($accion=="agregar")
            $this->verificarDatosAAgregar($datosRequest);
            
            if($accion=="modificar")
            $this->verificarDatosAModificar($datosRequest);

            if($accion=="eliminar")
            $this->eliminarAlmacen($datosRequest);

            if($accion=="recuperar")
            $this->recuperarAlmacen($datosRequest);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error,no se pudo  procesar la accion';
            Session::put('respuesta', $mensajeDeError);
        }
        return redirect()->route('backoffice.almacen');
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
                $this->crearAlmacen($datosRequest);
            } catch (\Exception $e) {
                $mensajeDeError = 'Error:Debe ingresar datos para realizar esta accion';
                Session::put('respuesta', $mensajeDeError);
            }
        }
    }

    private function obtenerIdsClase($datoClase)
    { {
            try {
                $datoId = [];
                foreach ($datoClase as $dato) {
                    $datoId[] = $dato['id'];
                }
                return $datoId;
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
            $this->modificarAlmacen($datosRequest);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:Debe ingresar datos para realizar esta accion';
            Session::put('respuesta', $mensajeDeError);
        }

    }

    public function eliminarAlmacen($datosRequest)
    { {
            try {
                $id = $datosRequest['identificador'];
                $almacen = Almacenes::withoutTrashed()->find($id);
                if ($almacen) {
                    $almacen->delete();
                }
                $mensajeConfirmacion = 'Almacen eliminado exitosamente';
                Session::put('respuesta', $mensajeConfirmacion);
                $this->cargarDatos();
            } catch (\Exception $e) {
                $mensajeDeError = 'Error,no se pudo eliminar el almacen';
                Session::put('respuesta', $mensajeDeError);
            }
        }
    }

    public function recuperarAlmacen($datosRequest)
    { {
            try {
                $id = $datosRequest['identificador'];
                $almacen = Almacenes::onlyTrashed()->find($id);
                if ($almacen) {
                    $almacen->restore();
                }
                $mensajeConfirmacion = 'Almacen restaurado exitosamente';
                Session::put('respuesta', $mensajeConfirmacion);
                $this->cargarDatos();

            } catch (\Exception $e) {
                $mensajeDeError = 'Error:no se pudo restaurar el almacen';
                Session::put('respuesta', $mensajeDeError);
            }
        }
    }

    private function obtenerDatosAlmacenes($almacen)
    { {
            try {
                $lugarAlmacen = Lugares_Entrega::withTrashed()->where('id', $almacen['id_lugar_entrega'])->first();
                return [
                    'Id Almacen' => $almacen['id'],
                    'Id Lugar' => $lugarAlmacen['id'],
                    'Direccion Almacen' => $lugarAlmacen['direccion'],
                    'Lat Almacen' => $lugarAlmacen['latitud'],
                    'Lng Almacen' => $lugarAlmacen['longitud'],
                    'created_at' => $almacen['created_at'],
                    'updated_at' => $almacen['updated_at'],
                    'deleted_at' => $almacen['deleted_at'],
                ];
            } catch (\Exception $e) {
                $mensajeDeError = 'Error: No se pudieron cargar los datos del producto ' . $almacen['id'];
                Session::put('respuesta', $mensajeDeError);
            }
        }
    }

    private function validarDatos($almacen)
    {
        $reglas = [
            'lugar' => 'required|numeric',
        ];
        $messages = [
            'lugar.required' => 'Es necesario que ingreses el Id de un Lugar',
            'lugar.numeric' => 'El Id del Lugar debe ser un Numero'
        ];
        return Validator::make([
            'lugar' => $almacen['idLugarEntrega'],
        ], $reglas, $messages);

    }

    private function crearAlmacen($almacen)
    { {
            try {
                $nuevaAlmacen = new Almacenes;
                $nuevaAlmacen->id_lugar_entrega = $almacen['idLugarEntrega'];
                $nuevaAlmacen->save();
                $mensajeConfirmacion = 'Almacen creado exitosamente';
                Session::put('respuesta', $mensajeConfirmacion);
                $this->cargarDatos();
            } catch (\Exception $e) {
                $mensajeDeError = 'Error:no se pudo crear el almacen';
                Session::put('respuesta', $mensajeDeError);
            }
        }
    }

    private function modificarAlmacen($lugarAlmacen)
    { {
            try {
                Almacenes::where('id', $lugarAlmacen['identificador'])->update([
                    'id_lugar_entrega' => $lugarAlmacen['idLugarEntrega']
                ]);
                $mensajeConfirmacion = 'Almacen modificado exitosamente';
                Session::put('respuesta', $mensajeConfirmacion);
                $this->cargarDatos();
            } catch (\Exception $e) {
                $mensajeDeError = 'Error:no se pudo modificar el almacen';
                Session::put('respuesta', $mensajeDeError);
            }
        }
    }
}