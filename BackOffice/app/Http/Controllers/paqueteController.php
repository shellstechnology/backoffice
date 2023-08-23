<?php

namespace App\Http\Controllers;

use App\Models\Caracteristicas;
use App\Models\Lugares_Entrega;
use App\Models\Paquetes;
use App\Models\Productos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class paqueteController extends Controller
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
        return redirect()->route('backoffice.paquete');
    }

    public function cargarDatos()
    {
        $datoPaquete = Paquetes::withTrashed()->get();
        $infoPaquete = [];
        $datoLugarEntrega = Lugares_Entrega::withoutTrashed()->get();
        $idLugaresEntrega = [];
        if ($datoPaquete) {
            foreach ($datoPaquete as $dato) {
                $infoPaquete[] = $this->definirPaquete($dato);
            }
        }
        $idLugaresEntrega = $this->definirLugaresEntrega($datoLugarEntrega);
        $idLugaresEntrega[] = $this->definirLugaresEntrega($dato);
        Session::put('lugaresEntrega', $idLugaresEntrega);
        Session::put('paquete', $infoPaquete);
        return redirect()->route('backoffice.paquete');
    }

    public function agregar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            $errores = $validador->getMessageBag();
            return response()->json(['error:' => $errores], 422);
        }
        $this->crearPaquete($datosRequest);
    }
    public function modificar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            $errores = $validador->getMessageBag();
            return response()->json(['error:' => $errores], 422);
        }
        $this->modificarPaquete($datosRequest);

    }
    public function eliminar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $paquete = Paquetes::withoutTrashed()->where('id', $id)->first();
        if ($paquete) {
            Caracteristicas::where('id', $paquete['id_caracteristica_paquete'])->delete();
            Paquetes::where('id', $id)->delete();

        }
    }

    public function recuperar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $paquete = Paquetes::onlyTrashed()->where('id', $id)->first();
        if ($paquete) {
            Paquetes::where('id', $id)->update();
            Caracteristicas::where('id', $paquete['id_caracteristica_paquete'])->update();
        }
    }

    private function definirPaquete($paquete)
    {
        $lugarEntrega = Lugares_Entrega::withTrashed()->where('id', $paquete['id_lugar_entrega'])->first();
        $caracteristica = Caracteristicas::withTrashed()->where('id', $paquete['id_caracteristica_paquete'])->first();
        $producto = Productos::withTrashed()->where('id', $paquete['id_producto'])->first();
        if ($producto && $lugarEntrega && $caracteristica) {
            return (
                [
                    'Id Paquete' => $paquete['id'],
                    'Fecha de Entrega' => $paquete['fecha_de_entrega'],
                    'Id Lugar Entrega' => $lugarEntrega['id'],
                    'Direccion' => $lugarEntrega['direccion'],
                    'Caracteristicas' => $caracteristica['descripcion'],
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

    private function definirLugaresEntrrega($datoLugarEntrega)
    {
        $datoLugares=[];
        foreach($datoLugarEntrega as $dato){
            $datoLugares[]=$dato['id'];
        }
        return $datoLugares;
    }

    private function validarDatos($paquete)
    {
        $reglas = [
            'Caracteristica' => 'required|string|max:100',
            'Nombre Remitente' => 'required|string|max:20',
            'Nombre Destinatario' => 'required|string|max:20',
            'Volumen' => 'required|numeric|min:1|max:999',
            'Peso' => 'required|numeric|min:1|max:999',
        ];
        return Validator::make([
            'Caracteristica' => $paquete['caracteristica'],
            'Nombre Remitente' => $paquete['nombreRemitente'],
            'Nombre Destinatario' => $paquete['nombreDestiatario'],
            'Volumen' => $paquete['volumen'],
            'Peso' => $paquete['peso']
        ], $reglas);
    }

    private function crearPaquete($paquete)
    {
        $caracteristica = new Caracteristicas;
        $caracteristica->descripcion = $paquete[4];
        $caracteristica->save();
        $dia = $paquete['dia'];
        $mes = $paquete['mes'];
        $anio = $paquete['anio'];
        $fechaEntrega = sprintf('%04d-%02d-%02d', $anio, $mes, $dia);
        $nuevoPaquete = new Paquetes;
        $nuevoPaquete->fecha_de_entrega = $fechaEntrega;
        $nuevoPaquete->id_lugar_entrega = $paquete['idLugarEntrega'];
        $nuevoPaquete->id_caracteristica_paquete = $caracteristica->id;
        $nuevoPaquete->nombre_remitente = $paquete['nombreRemitente'];
        $nuevoPaquete->nombre_destinatario = $paquete['nombreDestinatario'];
        $nuevoPaquete->id_producto = $paquete['idProducto'];
        $nuevoPaquete->volumen_l = $paquete['volumen'];
        $nuevoPaquete->peso_kg = $paquete['peso'];
        $nuevoPaquete->save();
    }

    private function modificarPaquete($paquete)
    {
        $paqueteSeleccionado = Paquetes::where('id', $paquete['id'])->first();
        Caracteristicas::where('id', $paqueteSeleccionado['id_caracteristica_paquete'])->update([
            'Descripcion' => $paquete['descripcion']
        ]);
        $dia = $paquete['dia'];
        $mes = $paquete['mes'];
        $anio = $paquete['anio'];
        $fechaEntrega = sprintf('%04d-%02d-%02d', $anio, $mes, $dia);
        Paquetes::where('Id', $paquete['identificador'])->update([
            'fecha_de_entrega' => $fechaEntrega,
            'nombre_remitente' => $paquete['nombreRemitente'],
            'nombre_destinatario' => $paquete['nombreDestinatario'],
            'id_producto' => $paquete['idProducto'],
            'volumen_l' => $paquete['volumen'],
            'peso_kg' => $paquete['peso'],
        ]);
    }
}