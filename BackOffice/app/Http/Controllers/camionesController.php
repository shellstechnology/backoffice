<?php

namespace App\Http\Controllers;

use App\Models\Camion_Lleva_Lote;
use App\Models\Camiones;
use App\Models\Chofer_Conduce_Camion;
use App\Models\Choferes;
use App\Models\Estados_c;
use App\Models\Marcas;
use App\Models\Modelos;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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
            return;
        }
        $this->crearCamion($datosRequest);
    }

    private function validarDatos($camion)
    {
        $reglas = [
            'Matricula' => 'required|string|max:10',
            'Marca Modelo'=>'required|string|max:101',
            'Chofer'=>'required|string|max:50',
            'Estado'=>'required|string|max:100',
            'Volumen' => 'required|numeric|min:0|max:99999',
            'Peso' => 'required|numeric|min:0|max:99999',
        ];
        return Validator::make([
            'Matricula' => $camion['matricula'],
            'Marca Modelo'=>$camion['marcaModeloCamion'],
            'Chofer'=>$camion['chofer'],
            'Estado'=>$camion['estadoCamion'],
            'Volumen' => $camion['volumen'],
            'Peso' => $camion['peso'],
        ], $reglas);
    }

    private function crearCamion($camion)
    {
        $choferExistente=Chofer_Conduce_Camion::withoutTrashed()->where('matricula_camion',$camion['matricula'])->first();
        if($choferExistente!=null){
            return;
        }
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
           return;
        }
        $this->modificarCamion($datosRequest);

    }

    private function modificarCamion($camion)
    {
       

        list($marca, $modelo) = explode(':', $camion['marcaModeloCamion']);
        $idModelo = Modelos::withTrashed()->where('modelo', $modelo)->first();
        $idMarca = Marcas::withTrashed()->where('marca', $marca)->where('id_modelo', $idModelo['id'])->first();
        $estado = Estados_c::withTrashed()->where('descripcion_estado_c', $camion['estadoCamion'])->first();
        if($camion['matricula']!=$camion['identificador']){
            $this->crearNuevoCamion($camion,$idMarca,$estado);
        }
        Camiones::withTrashed()->where('matricula',$camion['identificador'])->update([
            'id_marca_modelo'=>$idMarca['id'],
            'id_estado_c'=>$estado['id'],
            'volumen_max_l'=>$camion['volumen'],
            'peso_max_kg'=>$camion['peso']
        
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
        if($camion['matricula']!=$camion['identificador'])
        Camiones::withTrashed()->where('matricula', $camion['identificador'])->forceDelete();
    }

    private function crearNuevoCamion($camion,$idMarca,$estado)
    {
        $nuevoCamion = new Camiones;
        $nuevoCamion->matricula = $camion['matricula'];
        $nuevoCamion->id_marca_modelo = $idMarca['id'];
        $nuevoCamion->id_estado_c = $estado['id'];
        $nuevoCamion->volumen_max_l = $camion['volumen'];
        $nuevoCamion->peso_max_kg = $camion['peso'];
        $nuevoCamion->save();
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