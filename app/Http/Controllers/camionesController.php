<?php

namespace App\Http\Controllers;

use App\Models\camion_lleva_lote;
use App\Models\camiones;
use App\Models\chofer_conduce_camion;
use App\Models\choferes;
use App\Models\estados_c;
use App\Models\marcas;
use App\Models\modelos;
use App\Models\usuarios;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class camionesController extends Controller
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
                $this->eliminarCamion($datosRequest);
                break;
            case 'recuperar':
                $this->recuperarCamion($datosRequest);
                break;
        }
        return redirect()->route('backoffice.camiones');
    }


    public function cargarDatos()
    {
        try {
            $datosCamion = [];
            $listaEstados = [];
            $listaMarcasModelo = [];
            $listaChoferes = [];
            $camiones = Camiones::withTrashed()->get();
            $estados = Estados_c::withoutTrashed()->get();
            $marcasModelo = Modelos::withoutTrashed()->get();
            $choferes = Choferes::withoutTrashed()->get();
            foreach ($camiones as $camion) {
                $datosCamion[] = $this->obtenerDatosCamion($camion);
            }
            foreach ($estados as $estado) {
                $listaEstados[] = $estado['descripcion_estado_c'];
            }
            foreach ($marcasModelo as $modeloMarca) {
                $listaMarcasModelo[] = $this->obtenerModeloMarca($modeloMarca);
            }
            foreach ($choferes as $chofer) {
                $listaChoferes[] = $this->obtenerChoferes($chofer);
            }
            Session::put('camiones', $datosCamion);
            Session::put('listaEstado', $listaEstados);
            Session::put('listaMarcaModelo', $listaMarcasModelo);
            Session::put('listaChoferes', $listaChoferes);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error al cargar los datos';
            Session::put('respuesta', $mensajeDeError);
        }
        return redirect()->route('backoffice.camiones');
    }


    private function obtenerDatosCamion($camion)
    {
        try {
            $modelo = Modelos::withTrashed()->where('id', $camion['id_modelo_marca'])->first();
            $marca = Marcas::withTrashed()->where('id', $modelo['id_marca'])->first();
            $marcaModelo = ($marca['marca'] . ':' . $modelo['modelo']);
            $idChofer = Chofer_Conduce_Camion::withTrashed()->where('matricula_camion', $camion['matricula'])->first();
            $estado = Estados_c::withTrashed()->withTrashed()->where('id', $camion['id_estado_c'])->first();
            $chofer = Usuarios::withTrashed()->where('id', $idChofer['id_chofer'])->first();
            return ([
                'Matricula' => $camion['matricula'],
                'Marca y Modelo' => $marcaModelo,
                'Estado' => $estado['descripcion_estado_c'],
                'Chofer' => $chofer['nombre_de_usuario'],
                'Volumen Maximo' => $camion['volumen_max_l'],
                'Peso Maximo' => $camion['peso_max_kg'],
                'created_at' => $camion['created_at'],
                'updated_at' => $camion['updated_at'],
                'deleted_at' => $camion['deleted_at']
            ]);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudo cargar los datos de uno de los camiones';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function obtenerModeloMarca($modeloMarca)
    {
        try {
            $marca = Marcas::withTrashed()->where('id', $modeloMarca['id_marca'])->first();
            return ($marca['marca'] . ':' . $modeloMarca['modelo']);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudo cargar la marca de uno de los camiones';
            Session::put('respuesta', $mensajeDeError);
        }
    }


    private function obtenerChoferes($chofer)
    {
        try {
            $usuario = Usuarios::withTrashed()->where('id', $chofer['id_usuarios'])->first();
            return $usuario['nombre_de_usuario'];
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudo obtener el chofer de uno de los camiones';
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
            $this->agregarCamion($datosRequest);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:Debe ingresar datos para realizar esta accion';
            Session::put('respuesta', $mensajeDeError);
        }
    }


    private function validarDatos($camion)
    {
        $reglas = [
            'Matricula' => 'required|string|max:10',
            'Modelo Marca' => 'required|string|max:101',
            'Chofer' => 'required|string|max:50',
            'Estado' => 'required|string|max:100',
            'Volumen' => 'required|numeric|min:0|max:99999',
            'Peso' => 'required|numeric|min:0|max:99999',
        ];
        $messages = [
            'Matricula.required' => 'Es necesario ingresar una matrícula',
            'Matricula.string' => 'La matrícula debe ser una cadena de texto',
            'Matricula.max' => 'La matrícula no debe exceder los 10 caracteres',

            'Modelo Marca.required' => 'Es necesario ingresar la marca y modelo del camión',
            'Modelo Marca.string' => 'La marca y modelo del camión deben ser una cadena de texto',
            'Modelo Marca.max' => 'La marca y modelo del camión no deben exceder los 101 caracteres',

            'Chofer.required' => 'Es necesario ingresar el nombre del chofer',
            'Chofer.string' => 'El nombre del chofer debe ser una cadena de texto',
            'Chofer.max' => 'El nombre del chofer no debe exceder los 50 caracteres',

            'Estado.required' => 'Es necesario ingresar el estado del camión',
            'Estado.string' => 'El estado del camión debe ser una cadena de texto',
            'Estado.max' => 'El estado del camión no debe exceder los 100 caracteres',

            'Volumen.required' => 'Es necesario ingresar el volumen del camión',
            'Volumen.numeric' => 'El volumen del camión debe ser un número',
            'Volumen.min' => 'El volumen del camión no debe ser menor que 0',
            'Volumen.max' => 'El volumen del camión no debe exceder los 99999',

            'Peso.required' => 'Es necesario ingresar el peso del camión',
            'Peso.numeric' => 'El peso del camión debe ser un número',
            'Peso.min' => 'El peso del camión no debe ser menor que 0',
            'Peso.max' => 'El peso del camión no debe exceder los 99999',
        ];


        return Validator::make([
            'Matricula' => $camion['matricula'],
            'Modelo Marca' => $camion['marcaModeloCamion'],
            'Chofer' => $camion['chofer'],
            'Estado' => $camion['estadoCamion'],
            'Volumen' => $camion['volumen'],
            'Peso' => $camion['peso'],
        ], $reglas, $messages);
    }

    private function agregarCamion($camion)
    {
        try {
            $choferExistente = Chofer_Conduce_Camion::withoutTrashed()->where('matricula_camion', $camion['matricula'])->first();
            if ($choferExistente != null) {
                return;
            }
            $nuevoCamion = new Camiones;
            list($marca, $modelo) = explode(':', $camion['marcaModeloCamion']);
            $idModelo = Modelos::withTrashed()->where('modelo', $modelo)->first();
            $idUsuario = Usuarios::withTrashed()->where('nombre_de_usuario', $camion['chofer'])->first();
            $estado = Estados_c::withTrashed()->where('descripcion_estado_c', $camion['estadoCamion'])->first();
            $nuevoCamion->matricula = $camion['matricula'];
            $nuevoCamion->id_modelo_marca = $idModelo['id'];
            $nuevoCamion->id_estado_c = $estado['id'];
            $nuevoCamion->volumen_max_l = $camion['volumen'];
            $nuevoCamion->peso_max_kg = $camion['peso'];
            $nuevoCamion->save();

            $choferCoduceCamion = new Chofer_Conduce_Camion;
            $choferCoduceCamion->id_chofer = $idUsuario['id'];
            $choferCoduceCamion->matricula_camion = $nuevoCamion->getKey();
            $choferCoduceCamion->save();
            $mensajeConfirmacion = 'Camion agregado exitosamente';
            Session::put('respuesta', $mensajeConfirmacion);
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error,no se pudo agregar el camion';
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
            $this->modificarCamion($datosRequest);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:Debe ingresar datos para realizar esta accion';
            Session::put('respuesta', $mensajeDeError);
        }
    }



  
private function modificarCamion($camion)
{
    try {
        list($marca, $modelo) = explode(':', $camion['marcaModeloCamion']);
        $idModelo = Modelos::withTrashed()->where('modelo', $modelo)->first();
        $estado = Estados_c::withTrashed()->where('descripcion_estado_c', $camion['estadoCamion'])->first();
        if ($camion['matricula'] != $camion['identificador']) {
            $this->agregarNuevoCamion($camion, $idModelo, $estado);
        }
        Camiones::withTrashed()->where('matricula', $camion['matricula'])->update([
            'id_modelo_marca' => $idModelo['id'],
            'id_estado_c' => $estado['id'],
            'volumen_max_l' => $camion['volumen'],
            'peso_max_kg' => $camion['peso']
        ]);
        Camion_Lleva_Lote::withTrashed()->where('matricula', $camion['identificador'])->update([
            'matricula' => $camion['matricula']
        ]);
        Chofer_Conduce_Camion::withTrashed()->where('matricula_camion', $camion['identificador'])->update([
            'matricula_camion' => $camion['matricula']
        ]);
        $viejoCamion = Camiones::withTrashed()->where('matricula', $camion['identificador'])->first();
        if (!is_null($viejoCamion['created_at'])) {
            Camiones::withTrashed()->where('matricula', $camion['matricula'])->update([
                'created_at' => $viejoCamion['created_at']
            ]);
        }
        if ($camion['matricula'] != $camion['identificador'])
            Camiones::withTrashed()->where('matricula', $camion['identificador'])->forceDelete();
        
            $mensajeConfirmacion = 'Camion modificado exitosamente';
            Session::put('respuesta', $mensajeConfirmacion);
            $this->cargarDatos();
    } catch (\Exception $e) {
        $mensajeDeError = 'Error,no se pudo modificar el camion';
        Session::put('respuesta', $mensajeDeError);
    }
}


    private function agregarNuevoCamion($camion, $idModelo, $estado)
    {
        try {
            $nuevoCamion = new Camiones;
            $nuevoCamion->matricula = $camion['matricula'];
            $nuevoCamion->id_modelo_marca = $idModelo['id'];
            $nuevoCamion->id_estado_c = $estado['id'];
            $nuevoCamion->volumen_max_l = $camion['volumen'];
            $nuevoCamion->peso_max_kg = $camion['peso'];
            $nuevoCamion->save();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error,no se pudo agregar el camion';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    public function eliminarCamion($datosRequest)
    {
        try {
            $id = $datosRequest['identificador'];
            $camiones = Camiones::withTrashed()->find($id);
            if ($camiones) {
                Chofer_Conduce_Camion::withTrashed()->where('matricula_camion', $camiones['matricula'])->delete();
                $camiones->delete();
            }
            $mensajeConfirmacion = 'Camion eliminado exitosamente';
            Session::put('respuesta', $mensajeConfirmacion);
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:no se pudo eliminar el camion';
            Session::put('respuesta', $mensajeDeError);
        }
    }


    public function recuperarCamion($datosRequest)
    {
        try {
            $id = $datosRequest['identificador'];
            $camiones = Camiones::onlyTrashed()->find($id);
            if ($camiones) {
                $camiones->restore();
                Chofer_Conduce_Camion::onlyTrashed()->where('matricula_camion', $camiones['matricula'])->restore();
            }
            $mensajeConfirmacion = 'Camion recuperado exitosamente';
            Session::put('respuesta', $mensajeConfirmacion);
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:no se pudo recuperar el camion';
            Session::put('respuesta', $mensajeDeError);
        }
    }
}