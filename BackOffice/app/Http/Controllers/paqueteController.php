<?php

namespace App\Http\Controllers;

use App\Models\Caracteristicas;
use App\Models\Estados_p;
use App\Models\Lugares_Entrega;
use App\Models\Paquetes;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class paqueteController extends Controller
{
    public function realizarAccion(Request $request)
    {
        $datosRequest = $request->all();
        switch ($request->has('accion')) {
            case 'agregar':
                $this->verificarDatosAgregar($datosRequest);
                break;
            case 'modificar':
                $this->verificarDatosModificar($datosRequest);
                break;
            case 'eliminar':
                $this->eliminarPaquete($datosRequest);
                break;
            case 'recuperar':
                $this->recuperarPaquete($datosRequest);
                break;
        };
        $this->cargarDatos();
        return redirect()->route('backoffice.paquete');

    }

    public function cargarDatos()
    {
        $datoPaquete = Paquetes::withTrashed()->get();
        $infoPaquete = [];
        $datoLugarEntrega = Lugares_Entrega::withoutTrashed()->get();
        $idLugaresEntrega = [];
        $datoProducto = Producto::withoutTrashed()->get();
        $idProductos = [];
        $datoCaracteristica = Caracteristicas::withoutTrashed()->get();
        $descripcionCaracteristica = [];
        $datoEstadoPaquete = Estados_p::withoutTrashed()->get();
        $estadoPaquete = [];
        foreach ($datoPaquete as $dato) {
            $infoPaquete[] = $this->obtenerPaquete($dato);
        }
        foreach ($datoCaracteristica as $dato) {
            $descripcionCaracteristica[] = $dato['descripcion_caracteristica'];
        }
        foreach($datoEstadoPaquete as $dato){
            $estadoPaquete[]=$dato['descripcion_estado_p'];
        }
        $idLugaresEntrega = $this->obtenerIdsClase($datoLugarEntrega);
        $idProductos = $this->obtenerIdsClase($datoProducto);
        Session::put('descripcionCaracteristica', $descripcionCaracteristica);
        Session::put('idProductos', $idProductos);
        Session::put('idLugaresEntrega', $idLugaresEntrega);
        Session::put('paquete', $infoPaquete);
        Session::put('estadoPaquete', $estadoPaquete);
        return redirect()->route('backoffice.paquete');
    }

    public function verificarDatosAgregar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
           return;
        }
        $this->crearPaquete($datosRequest);
    }
    public function verificarDatosModificar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            return;
        }
        $this->modificarPaquete($datosRequest);

    }
    public function eliminarPaquete($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $paquete = Paquetes::withoutTrashed()->where('id', $id)->first();
        if ($paquete) {
            Paquetes::where('id', $id)->delete();

        }
    }

    public function recuperarPaquete($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $paquete = Paquetes::onlyTrashed()->where('id', $id)->first();
        if ($paquete) {
            Paquetes::where('id', $id)->restore();
        }
    }

    private function obtenerPaquete($paquete)
    {
        $lugarEntrega = Lugares_Entrega::withTrashed()->where('id', $paquete['id_lugar_entrega'])->first();
        $caracteristica = Caracteristicas::withTrashed()->where('id', $paquete['id_caracteristica_paquete'])->first();
        $estado=Estados_p::withTrashed()->where('id',$paquete['id_estado_p'])->first();
        $producto = Producto::withTrashed()->where('id', $paquete['id_producto'])->first();
        if ($producto && $lugarEntrega && $caracteristica) {
            return (
                [
                    'Id Paquete' => $paquete['id'],
                    'Nombre del Paquete' => $paquete['nombre'],
                    'Fecha de Entrega' => $paquete['fecha_de_entrega'],
                    'Id Lugar Entrega' => $lugarEntrega['id'],
                    'Direccion' => $lugarEntrega['direccion'],
                    'Estado'=>$estado['descripcion_estado_p'],
                    'Caracteristicas' => $caracteristica['descripcion_caracteristica'],
                    'Nombre del Remitente' => $paquete['nombre_remitente'],
                    'Nombre del Destinatario' => $paquete['nombre_destinatario'],
                    'Id del Producto' => $producto['id'],
                    'Producto' => $producto['nombre'],
                    'Volumen(L)' => $paquete['volumen_l'],
                    'Peso(Kg)' => $paquete['peso_kg'],
                    'created_at' => $paquete['created_at'],
                    'updated_at' => $paquete['updated_at'],
                    'deleted_at' => $paquete['deleted_at'],
                ]);
        }
    }

    private function obtenerIdsClase($datoClase)
    {
        $datoId = [];
        foreach ($datoClase as $dato) {
            $datoId[] = $dato['id'];
        }
        return $datoId;
    }

    private function validarDatos($paquete)
    {
        $reglas = [
            'nombrePaquete'=>'required|string|max:50',
            'dia'=>'required|numeric|min:1|max:31',
            'mes'=>'required|numeric|min:1|max:12|',
            'anio'=>'required|numeric|min:2023|max:2050',
            'idLugarEntrega'=>'required|numeric',
            'estadoPaquete'=>'required|string|max:100',
            'caracteristica' => 'required|string|max:100',
            'nombreRemitente' => 'required|string|max:40',
            'nombreDestinatario' => 'required|string|max:40',
            'idProducto'=>'required|integer',
            'volumen' => 'required|numeric|min:1|max:99999',
            'peso' => 'required|numeric|min:1|max:99999',
        ];
        return Validator::make([
            'nombrePaquete'=>$paquete['nombrePaquete'],
            'dia'=>$paquete['dia'],
            'mes'=>$paquete['mes'],
            'anio'=>$paquete['anio'],
            'idLugarEntrega'=>$paquete['idLugarEntrega'],
            'estadoPaquete'=>$paquete['estadoPaquete'],
            'nombreRemitente'=>$paquete['nombreRemitente'],
            'nombreDestinatario'=>$paquete['nombreDestinatario'],
            'caracteristica' => $paquete['caracteristica'],
            'idProducto'=>$paquete['idProducto'],
            'volumen' => $paquete['volumen'],
            'peso' => $paquete['peso']
        ], $reglas);
    }

    private function crearPaquete($paquete)
    {
        $caracteristica = $this->obtenerIdCaracteristica($paquete);
        $estado=$this->obtenerIdEstado($paquete);
        $dia = $paquete['dia'];
        $mes = $paquete['mes'];
        $anio = $paquete['anio'];
        $fechaEntrega = sprintf('%04d-%02d-%02d', $anio, $mes, $dia);
        $nuevoPaquete = new Paquetes;
        $nuevoPaquete->fecha_de_entrega = $fechaEntrega;
        $nuevoPaquete->id_lugar_entrega = $paquete['idLugarEntrega'];
        $nuevoPaquete->nombre = $paquete['nombrePaquete'];
        $nuevoPaquete->id_estado_p=$estado;
        $nuevoPaquete->id_caracteristica_paquete = $caracteristica;
        $nuevoPaquete->nombre_remitente = $paquete['nombreRemitente'];
        $nuevoPaquete->nombre_destinatario = $paquete['nombreDestinatario'];
        $nuevoPaquete->id_producto = $paquete['idProducto'];
        $nuevoPaquete->volumen_l = $paquete['volumen'];
        $nuevoPaquete->peso_kg = $paquete['peso'];
        $nuevoPaquete->save();
    }

    private function modificarPaquete($paquete)
    {

        $caracteristica = $this->obtenerIdCaracteristica($paquete);
        $estado=$this->obtenerIdEstado($paquete);
        $dia = $paquete['dia'];
        $mes = $paquete['mes'];
        $anio = $paquete['anio'];
        $fechaEntrega = sprintf('%04d-%02d-%02d', $anio, $mes, $dia);
        Paquetes::where('id', $paquete['identificador'])->update([
            'nombre'=>$paquete['nombrePaquete'],
            'fecha_de_entrega' => $fechaEntrega,
            'nombre_remitente' => $paquete['nombreRemitente'],
            'id_lugar_entrega'=>$paquete['idLugarEntrega'],
            'nombre_destinatario' => $paquete['nombreDestinatario'],
            'id_estado_p'=>$estado,
            'id_caracteristica_paquete' => $caracteristica,
            'id_producto' => $paquete['idProducto'],
            'volumen_l' => $paquete['volumen'],
            'peso_kg' => $paquete['peso'],
        ]);
    }

    private function obtenerIdCaracteristica($paquete)
    {
        $caracteristica = Caracteristicas::withoutTrashed()->where('descripcion_caracteristica', $paquete['caracteristica'])->first();
        return $caracteristica['id'];
    }

    private function obtenerIdEstado($paquete){
        $estado = Estados_p::withTrashed()->where('descripcion_estado_p',$paquete['estadoPaquete'])->first();
        return $estado['id'];
    }
}