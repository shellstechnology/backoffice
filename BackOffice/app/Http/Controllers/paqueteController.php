<?php

namespace App\Http\Controllers;

use App\Models\Caracteristicas;
use App\Models\Lugares_Entrega;
use App\Models\Paquetes;
use App\Models\Productos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class paqueteController extends Controller
{
    public function cargarDatos()
    {
        $datoProducto = Paquetes::withTrashed()->get();
        $infoPaquete = [];
        if ($datoProducto) {
            foreach ($datoProducto as $dato) {
                $infoPaquete[] = $this->definirPaquete($dato);
            }
        }
        return response()->json($infoPaquete);
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
            Caracteristicas::where('Id', $paquete['IdCaracteristica'])->delete();
            Paquetes::where('Id', $id)->delete();
    
        }
    }

    public function recuperar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        $paquete = Paquetes::onlyTrashed()->where('id', $id)->first();
        if ($paquete) {
            Paquetes::where('Id', $id)->update();
            Caracteristicas::where('Id', $paquete['IdCaracteristica'])->update();
        }
    }

    private function definirPaquete($paquete)
    {
        $lugarEntrega = Lugares_Entrega::withTrashed()->where('id', $paquete['id_lugar_entrega'])->first();
        $caracteristica = Caracteristicas::withTrashed()->where('id', $paquete['id_caracteristica_paquete'])->first();
        $producto = Productos::withTrashed()->where('id', $paquete['id_producto'])->first();
        if ($producto && $lugarEntrega && $caracteristica) {
            return(
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

    private function validarDatos($lugarEntrega)
    {
        $reglas = [
            'Caracteristica' => 'required|string|max:100',
            'Nombre Remitente' => 'required|string|max:20',
            'Nombre Destinatario' => 'required|string|max:20',
            'Volumen' => 'required|numeric|min:1|max:999',
            'Peso' => 'required|numeric|min:1|max:999',
        ];
        return Validator::make([
            'Caracteristica' => $lugarEntrega['caracteristica'],
            'Nombre Remitente' => $lugarEntrega['nombreRemitente'],
            'Nombre Destinatario' => $lugarEntrega['nombreDestiatario'],
            'Volumen' => $lugarEntrega['volumen'],
            'Peso' => $lugarEntrega['peso']
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
        $paquete = new Paquetes;
        $paquete->fecha_de_entrega = $fechaEntrega;
        $paquete->id_lugar_entrega = $paquete['idLugarEntrega'];
        $paquete->id_caracteristica_paquete = $caracteristica->id;
        $paquete->nombre_remitente = $paquete['nombreRemitente'];
        $paquete->nombre_destinatario = $paquete['nombreDestinatario'];
        $paquete->id_producto = $paquete['idProducto'];
        $paquete->volumen_l = $paquete['volumen'];
        $paquete->peso_kg = $paquete['peso'];
        $paquete->save();
    }

    private function modificarPaquete($paquete){
        $paqueteSeleccionado = Paquetes::where('id', $paquete['id'])->first();
        Caracteristicas::where('d', $paquete['id_caracteristica_paquete'])->update([
            'Descripcion' => $paquete[5]
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