<?php

namespace App\Http\Controllers;

use App\Models\Camion_Lleva_Lote;
use App\Models\Camiones;
use App\Models\Lotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class camionLlevaLoteController extends Controller
{
    public function realizarAccion(Request $request)
    {
        try {
            $datosRequest = $request->all();
            switch ($request->has('accion')) {
                case 'agregar':
                    $this->verificarDatosAgregar($datosRequest);
                    break;
                case 'modificar':
                    $this->verificarDatosModificar($datosRequest);
                    break;
                case 'eliminar':
                    $this->eliminarCamionLlevaLote($datosRequest);
                    break;
                case 'recuperar':
                    $this->recuperarCamionLlevaLote($datosRequest);
                    break;
            }
            $this->cargarDatos();
            return redirect()->route('camion.camionLlevaLote');
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudo realizar la acción';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    public function cargarDatos()
    {
        try {
            $datosCamionLlevaLote = Camion_Lleva_Lote::withTrashed()->get();
            $infoCamionLlevaLote = [];
            $matriculaCamion = [];
            $idLote = [];
            foreach ($datosCamionLlevaLote as $camionLlevaLote) {
                $infoCamionLlevaLote[] = $this->obtenerCamionLlevaLote($camionLlevaLote);
            }
            $camiones = Camiones::withoutTrashed()->get();
            foreach ($camiones as $camion) {
                $matriculaCamion[] = $camion['matricula'];
            }
            $lote = Lotes::withoutTrashed()->get();
            foreach ($lote as $datoLote) {
                $idLote[] = $datoLote['id'];
            }
            Session::put('matriculaCamiones', $matriculaCamion);
            Session::put('idLotes', $idLote);
            Session::put('camionLlevaLote', $infoCamionLlevaLote);
            return redirect()->route('camion.camionLlevaLote');
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudieron cargar los datos';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    public function verificarDatosAgregar($datosRequest)
    {
        try {
            $validador = $this->validarDatos($datosRequest);
            if ($validador->fails()) {
                return;
            }
            $camionLlevaLoteExistente = Camion_Lleva_Lote::where('id_lote', $datosRequest['idLote'])->first();
            if (!$camionLlevaLoteExistente) {
                $this->crearCamionLlevaLote($datosRequest);
            }
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudieron verificar los datos para agregar';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function validarDatos($camionLlevaLote)
    {
        $reglas = [
            'Id Lote' => 'required|integer',
            'Matricula' => 'required|string|max:10',
        ];
        return Validator::make([
            'Id Lote' => $camionLlevaLote['idLote'],
            'Matricula' => $camionLlevaLote['idCamion'],
        ], $reglas);
    }

    public function verificarDatosModificar($datosRequest)
    {
        try {
            $validador = $this->validarDatos($datosRequest);
            if ($validador->fails()) {
                return;
            }
            $this->modificarCamionLlevaLote($datosRequest);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudieron verificar los datos para modificar';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    public function eliminarCamionLlevaLote($datosRequest)
    {
        try {
            $id = $datosRequest['identificador'];
            $camionLlevaLoteAntiguo = Camion_Lleva_Lote::withoutTrashed()->where('id_lote', $id)->first();
            if ($camionLlevaLoteAntiguo) {
                $camionLlevaLoteAntiguo->delete();
            }
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudo eliminar el camión que lleva el lote';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    public function recuperarCamionLlevaLote($datosRequest)
    {
        try {
            $id = $datosRequest['identificador'];
            $camionLlevaLote = Camion_Lleva_Lote::onlyTrashed()->where('id_lote', $id)->first();
            if ($camionLlevaLote) {
                $camionLlevaLote->restore();
            }
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudo recuperar el camión que lleva el lote';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function obtenerCamionLlevaLote($camionLlevaLote)
    {
        $infoCamionLlevaLote = [
            'Id Lote' => $camionLlevaLote['id_lote'],
            'Matricula Camion' => $camionLlevaLote['matricula'],
            'created_at' => $camionLlevaLote['created_at'],
            'updated_at' => $camionLlevaLote['updated_at'],
            'deleted_at' => $camionLlevaLote['deleted_at']
        ];
        return $infoCamionLlevaLote;
    }

    private function crearCamionLlevaLote($camionLlevaLote)
    {
        $id = $camionLlevaLote['idLote'];
        $matricula = $camionLlevaLote['idCamion'];
        $camionLlevaLote = new Camion_Lleva_Lote;
        $camionLlevaLote->id_lote = $id;
        $camionLlevaLote->matricula = $matricula;
        $camionLlevaLote->save();
    }

    private function modificarCamionLlevaLote($camionLlevaLote)
    {
        try {
            Camion_Lleva_Lote::withTrashed()->where('id_lote', $camionLlevaLote['identificador'])->update([
                'id_lote' => $camionLlevaLote['idLote'],
                'matricula' => $camionLlevaLote['idCamion']
            ]);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudo modificar el camión que lleva el lote';
            Session::put('respuesta', $mensajeDeError);
        }
    }
}
