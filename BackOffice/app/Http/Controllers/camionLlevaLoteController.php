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
        $datosRequest = $request->all();
        switch ($request->input('accion')) {
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
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
        return redirect()->route('camion.camionLlevaLote');
    }

    public function verificarDatosAgregar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            $errores = $validador->getMessageBag();
            $patron = '"';
            $resultado = str_replace($patron, '', json_encode($errores->messages()));
            Session::put('respuesta', $resultado);
            return;
        }
        try {
            $camionLlevaLoteExistente = Camion_Lleva_Lote::where('id_lote', $datosRequest['idLote'])->first();
            if (!$camionLlevaLoteExistente) {
                $this->crearCamionLlevaLote($datosRequest);
            }
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
    }

    private function validarDatos($camionLlevaLote)
    {
        $reglas = [
            'Id Lote' => 'required|integer',
            'Matricula' => 'required|string|max:10',
        ];
        $messages = [
            'Id Lote.required' => 'Es necesario ingresar el ID del lote',
            'Id Lote.integer' => 'El ID del lote debe ser un número entero',
            'Matricula.required' => 'Es necesario ingresar la matrícula del camión',
            'Matricula.string' => 'La matrícula del camión debe ser una cadena de texto',
            'Matricula.max' => 'La matrícula del camión no debe exceder los 10 caracteres',
        ];

        return Validator::make([
            'Id Lote' => $camionLlevaLote['idLote'],
            'Matricula' => $camionLlevaLote['idCamion'],
        ], $reglas, $messages);
    }

    public function verificarDatosModificar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            $errores = $validador->getMessageBag();
            $patron = '"';
            $resultado = str_replace($patron, '', json_encode($errores->messages()));
            Session::put('respuesta', $resultado);
            return;
        }
        try {
            $this->modificarCamionLlevaLote($datosRequest);
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
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
            Session::put('respuesta', $e->getMessage());
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
            Session::put('respuesta', $e->getMessage());
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
        try {
            $id = $camionLlevaLote['idLote'];
            $matricula = $camionLlevaLote['idCamion'];
            try {
                $camionLlevaLote = new Camion_Lleva_Lote;
                $camionLlevaLote->id_lote = $id;
                $camionLlevaLote->matricula = $matricula;
                $camionLlevaLote->save();
            } catch (\Exception $e) {
                Session::put('respuesta', $e->getMessage());
            }
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
    }

    private function modificarCamionLlevaLote($camionLlevaLote)
    {
        try {
            Camion_Lleva_Lote::withTrashed()->where('id_lote', $camionLlevaLote['identificador'])->update([
                'id_lote' => $camionLlevaLote['idLote'],
                'matricula' => $camionLlevaLote['idCamion']
            ]);
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
    }
}