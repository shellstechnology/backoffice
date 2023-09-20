<?php

namespace App\Http\Controllers;

use App\Models\Camiones;
use App\Models\Chofer_Conduce_Camion;
use App\Models\Choferes;
use App\Models\Estados_c;
use App\Models\Marcas;
use App\Models\Modelos;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class camionesController extends Controller
{
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
        return redirect()->route('backoffice.camiones');
    }

    public function cargarDatos()
    {
        $datosCamion = [];
        $listaEstados = [];
        $listaMarcasModelo = [];
        $listaChoferes = [];
        $camiones = Camiones::withTrashed()->get();
        $estados = Estados_c::withoutTrashed()->get();
        $marcasModelo = Marcas::withoutTrashed()->get();
        $choferes = Choferes::withoutTrashed()->get();
        foreach ($camiones as $camion) {
            $datosCamion[] = $this->obtenerDatosCamion($camion);
        }
        foreach ($estados as $estado) {
            $listaEstados[] = $estado['descripcion_estado_c'];
        }
        foreach ($marcasModelo as $marcaModelo) {
            $listaMarcasModelo[] = $this->obtenerMarcasModelo($marcaModelo);
        }
        foreach ($choferes as $chofer) {
            $listaChoferes[] = $this->obtenerChoferes($chofer);
        }
        Session::put('camiones', $datosCamion);
        Session::put('listaEstado', $listaEstados);
        Session::put('listaMarcaModelo', $listaMarcasModelo);
        Session::put('listaChoferes', $listaChoferes);
        return redirect()->route('backoffice.camiones');
    }

    private function obtenerDatosCamion($camion)
    {
        $marca = Marcas::withTrashed()->where('id', $camion['id_marca_modelo'])->first();
        $modelo = Modelos::withTrashed()->where('id', $marca['id_modelo'])->first();
        $marcaModelo = ($marca['marca'] . ':' . $modelo['modelo']);
        $idChofer = Chofer_Conduce_Camion::withTrashed()->where('matricula_camion', $camion['matricula'])->first();
        $estado = Estados_c::withTrashed()->withTrashed()->where('id', $camion['id_estado_c'])->first();
        $chofer = Usuarios::withTrashed()->withTrashed()->where('id', $idChofer['id_chofer'])->first();
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
    }

    private function obtenerMarcasModelo($marcaModelo)
    {
        $modelo = Modelos::withTrashed()->where('id', $marcaModelo['id_modelo'])->first();
        return ($marcaModelo['marca'] . ':' . $modelo['modelo']);
    }

    private function obtenerChoferes($chofer)
    {
        $usuario = Usuarios::withTrashed()->where('id', $chofer['id_usuarios'])->first();
        return $usuario['nombre_de_usuario'];
    }

    public function agregar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            $errores = $validador->getMessageBag();
            return response()->json(['error:' => $errores], 422);
        }
        $this->crearCamion($datosRequest);
    }

    private function validarDatos($camion)
    {

        $reglas = [
            'Matricula' => 'required|string|max:10',
            'Volumen' => 'required|numeric|min:0|max:99999',
            'Peso' => 'required|numeric|min:0|max:99999',
        ];
        return Validator::make([
            'Matricula' => $camion['matricula'],
            'Volumen' => $camion['volumen'],
            'Peso' => $camion['peso'],
        ], $reglas);
    }

    private function crearCamion($camion)
    {
        $nuevoCamion = new Camiones;
        list($marca, $modelo) = explode(':', $camion['marcaModeloCamion']);
        $idModelo = Modelos::withTrashed()->where('modelo', $modelo)->first();
        $idMarca = Marcas::withTrashed()->where('marca', $marca)->where('id_modelo', $idModelo['id'])->first();
        $idUsuario = Usuarios::withTrashed()->where('nombre_de_usuario', $camion['chofer'])->first();
        $estado = Estados_c::withTrashed()->where('descripcion_estado_c', $camion['estadoCamion'])->first();
        $nuevoCamion->matricula = $camion['matricula'];
        $nuevoCamion->id_marca_modelo = $idMarca['id'];
        $nuevoCamion->id_estado_c = $estado['id'];
        $nuevoCamion->volumen_max_l = $camion['volumen'];
        $nuevoCamion->peso_max_kg = $camion['peso'];
        $nuevoCamion->save();

        $choferCoduceCamion = new Chofer_Conduce_Camion;
        $choferCoduceCamion->id_chofer = $idUsuario['id'];
        $choferCoduceCamion->matricula_camion = $nuevoCamion->getKey();
        $choferCoduceCamion->save();


    }

    public function modificar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            $errores = $validador->getMessageBag();
            return response()->json(['error:' => $errores], 422);
        }
        $this->modificarCamion($datosRequest);

    }

    private function modificarCamion($camion)
    {
        $estado = Estados_c::withTrashed()->where('descripcion_estado_c', $camion['estadoCamion'])->first();
        list($marca, $modelo) = explode(':', $camion['marcaModeloCamion']);
        $modeloCamion = Modelos::withTrashed()->where('modelo', $modelo)->first();
        $marcaCamion = Marcas::withTrashed()->where('marca', $marca)->where('id_modelo', $modeloCamion['id'])->first();
        Camiones::where('matricula', $camion['identificador'])->update([
            'matricula' => $camion['matricula'],
            'id_estado_c' => $estado['id'],
            'id_marca_modelo' => $marcaCamion['id'],
            'volumen_max_l' => $camion['volumen'],
            'peso_max_kg' => $camion['peso']
        ]);
    }

    public function eliminar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $camiones = Camiones::withTrashed()->find($id);
        if ($camiones) {
            Chofer_Conduce_Camion::withTrashed()->where('matricula_camion', $camiones['matricula'])->delete();
            $camiones->delete();
        }

    }

    public function recuperar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $camiones = Camiones::onlyTrashed()->find($id);
        if ($camiones) {
            $camiones->restore();
            Chofer_Conduce_Camion::onlyTrashed()->where('matricula_camion', $camiones['matricula'])->restore();
        }
    }
}