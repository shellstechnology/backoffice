<?php

namespace App\Http\Controllers;

use App\Models\Lotes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class loteController extends Controller
{
    public function realizarAccion(Request $request)
    {
        $datosRequest = $request->all();
        switch ($request->input('accion')) {
            case 'agregar':
                $this->agregarLote();
                break;
            case 'eliminar':
                $this->eliminarLote($datosRequest);
                break;
            case 'recuperar':
                $this->recuperarLote($datosRequest);
                break;
        }
        ;
        return redirect()->route('backoffice.lote');
    }

    public function cargarDatos()
    {
        try {
            $datoLote = Lotes::withTrashed()->get();
            $infoLote = [];
            if ($datoLote) {
                foreach ($datoLote as $lote) {
                    $infoLote[] = $this->obtenerDatosLotes($lote);
                }
                Session::put('lotes', $infoLote);
                return redirect()->route('backoffice.lote');
            }
        } catch (\Exception $e) {
            $mensajeDeError = 'Error,no se pudieron cargar los datos';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    public function agregarLote()
    {
        try {
            $lote = new Lotes;
            $lote->volumen_l = 0;
            $lote->peso_kg = 0;
            $lote->save();
            $mensajeRespuesta = 'Almacen agregado correctamente';
            Session::put('respuesta', $mensajeRespuesta);
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error,no se pudo agregar el lote';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    public function eliminarLote($datosRequest)
    {
        try {
            $id = $datosRequest['identificador'];
            $lote = Lotes::withoutTrashed()->find($id);
            if ($lote) {
                Lotes::where('id', $datosRequest['identificador'])->delete();
                $mensajeRespuesta = 'Almacen eliminado correctamente';
                Session::put('respuesta', $mensajeRespuesta);
            }
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error,no se pudo agregar el lote';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    public function recuperarLote($datosRequest)
    {
        try {
            $id = $datosRequest['identificador'];
            $lote = Lotes::onlyTrashed()->find($id);
            if ($lote) {
                Lotes::where('id', $id)->restore();
                $mensajeRespuesta = 'Almacen restaurado correctamente';
                Session::put('respuesta', $mensajeRespuesta);
            }
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error,no se pudo agregar el lote';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function obtenerDatosLotes($lote)
    {
        try {
            return ([
                'Id Lote' => $lote['id'],
                'Volumen(L)' => $lote['volumen_l'],
                'Peso(Kg)' => $lote['peso_kg'],
                'created_at' => $lote['created_at'],
                'updated_at' => $lote['updated_at'],
                'deleted_at' => $lote['deleted_at'],
            ]);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error,no se pudieron obtener los datos de un lote';
            Session::put('respuesta', $mensajeDeError);
        }

    }
}