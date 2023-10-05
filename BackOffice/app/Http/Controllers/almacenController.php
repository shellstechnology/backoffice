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
                Session::put('respuesta', $e->getMessage());
            }
            return redirect()->route('backoffice.almacen');
        }
    }
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
                $this->eliminarAlmacen($datosRequest);
                break;
            case 'recuperar':
                $this->recuperarAlmacen($datosRequest);
                break;
        }
        ;
        $this->cargarDatos();
        return redirect()->route('backoffice.almacen');
    }

    public function verificarDatosAAgregar($datosRequest)
    { {
            try {
                $validador = $this->validarDatos($datosRequest);
                if ($validador->fails()) {
                    $errores = $validador->getMessageBag();
                    $patron = '"';
                    $resultado = str_replace($patron, '', json_encode($errores->messages()));
                    Session::put('respuesta', $resultado);
                    return;
                }
                $this->crearAlmacen($datosRequest);

            } catch (\Exception $e) {
                Session::put('respuesta', $e->getMessage());
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
                Session::put('respuesta', $e->getMessage());
            }
        }
    }


    public function verificarDatosAModificar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            $errores = $validador->getMessageBag();
            $patron = '"';
            $resultado = str_replace($patron, '', json_encode($errores->messages()));
            Session::put('respuesta', $resultado);
            return;
        }
        $this->modificarAlmacen($datosRequest);

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
            } catch (\Exception $e) {
                Session::put('respuesta', $e->getMessage());
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

            } catch (\Exception $e) {
                Session::put('respuesta', $e);
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
                Session::put('respuesta', $e->getMessage());
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
            } catch (\Exception $e) {
                Session::put('respuesta', $e->getMessage());
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
            } catch (\Exception $e) {
                Session::put('respuesta', $e->getMessage());
            }
        }
    }
}