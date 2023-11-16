<?php

namespace App\Http\Controllers;

use App\Models\camion_Lleva_Lote;
use App\Models\camiones;
use App\Models\lotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class camionLlevaLoteController extends Controller
{
    public function realizarAccion(Request $request)
    {
        try {
            $datosRequest = $request->all();
            $accion=$request->input('accion');
            if($accion=="agregar")
            $this->verificarDatosAgregar($datosRequest);
            
            if($accion=="modificar")
            $this->verificarDatosModificar($datosRequest);
    
            if($accion=="eliminar")
            $this->eliminarCamionLlevaLote($datosRequest);
    
            if($accion=="recuperar")
            $this->recuperarCamionLlevaLote($datosRequest);
    
        } catch (\Exception $e) {
            $mensajeDeError = 'Error,no se pudo procesar la accion';
            Session::put('respuesta', $mensajeDeError);
        }
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
            $mensajeDeError = 'Error: no se pudieron cargar los datos';
            Session::put('respuesta', $mensajeDeError);
        }
        return redirect()->route('camion.camionLlevaLote');
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

            $camionLlevaLoteExistente = Camion_Lleva_Lote::where('id_lote', $datosRequest['idLote'])->first();
            if (!$camionLlevaLoteExistente) {
                $valoresLote=$this->comprobarValoresDelLote($datosRequest);
                if($valoresLote==true)
                $this->crearCamionLlevaLote($datosRequest);
               return;
            }
            $mensajeDeError = 'Error:Ese lote ya esta asignado a otro camion';
            Session::put('respuesta', $mensajeDeError);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:Debe ingresar datos para realizar esta accion';
            Session::put('respuesta', $mensajeDeError);
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
        try {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            $errores = $validador->getMessageBag();
            Session::put('respuesta', json_encode($errores->messages()));
            return;
        }
        $valoresLote=$this->comprobarValoresDelLote($datosRequest);
        if($valoresLote==true)
        $this->modificarCamionLlevaLote($datosRequest);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:Debe ingresar datos para realizar esta accion';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    public function comprobarValoresDelLote($datosRequest){
        $lote=Lotes::where('id',$datosRequest['idLote'])->first();
        $camion=camiones::where('matricula',$datosRequest['idCamion'])->first();
        $volumenTotal=$this->obtenerVolumenTotal($camion,$lote);
        $pesoTotal=$this->obtenerPesoTotal($camion,$lote);
        if($volumenTotal>$camion['volumen_max_l']){
            $mensajeDeError = 'El lote que esta intentando ingresar sobrepasa el volumen maximo que puede transportar el camion';
            Session::put('respuesta', $mensajeDeError);
            return false;
        }
        if($pesoTotal>$camion['peso_max_kg']){
            $mensajeDeError = 'El lote que esta intentando ingresar sobrepasa el peso maximo que puede transportar el camion';
            Session::put('respuesta', $mensajeDeError);
            return false;
        }
        return true;
    }  

    public function obtenerVolumenTotal($camion,$lote){
        $volumenTotal= 0;
        $lotesCamion=camion_Lleva_Lote::where('matricula',$camion)->get();
        foreach($lotesCamion as $datoLote){
            $loteEnCamion=lotes::where('id',$datoLote->id_lote)->first();
            $volumenTotal+=$loteEnCamion['volumen_l'];
        }
        $volumenTotal+=$lote['volumen_l'];
        return $volumenTotal;
    }

    public function obtenerPesoTotal($camion,$lote){
        $pesoTotal= 0;
        $lotesCamion=camion_Lleva_Lote::where('matricula',$camion)->get();
        foreach($lotesCamion as $datoLote){
            $loteEnCamion=lotes::where('id',$datoLote->id_lote)->first();
            $pesoTotal+=$loteEnCamion['peso_kg'];
        }
        $pesoTotal+=$lote['peso_kg'];
        return $pesoTotal;
    }

    public function eliminarCamionLlevaLote($datosRequest)
    {
        try {
            $id = $datosRequest['identificador'];
            $camionLlevaLoteAntiguo = Camion_Lleva_Lote::withoutTrashed()->where('id_lote', $id)->first();
            if ($camionLlevaLoteAntiguo) {
                $camionLlevaLoteAntiguo->delete();
                $mensajeConfirmacion = 'Lote eliminado del camion exitosamente';
                Session::put('respuesta', $mensajeConfirmacion);
            }
            $this->cargarDatos();
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
                $mensajeConfirmacion = 'Lote restaurado al camion exitosamente';
                Session::put('respuesta', $mensajeConfirmacion);
            }
            $this->cargarDatos();
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
        try {
            $camionLlevaLote = new Camion_Lleva_Lote;
            $camionLlevaLote->id_lote = $id;
            $camionLlevaLote->matricula = $matricula;
            $camionLlevaLote->save();
            $mensajeConfirmacion = 'Lote agregado a camion exitosamente';
            Session::put('respuesta', $mensajeConfirmacion);
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudo crear el camión que lleva el lote';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function modificarCamionLlevaLote($camionLlevaLote)
    {
        try {
            Camion_Lleva_Lote::withTrashed()->where('id_lote', $camionLlevaLote['idLote'])->update([
                'id_lote' => $camionLlevaLote['idLote'],
                'matricula' => $camionLlevaLote['idCamion']
            ]);
            $mensajeConfirmacion = 'Lote en camion modificado exitosamente';
            Session::put('respuesta', $mensajeConfirmacion);
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudo modificar el camión que lleva el lote';
            Session::put('respuesta', $mensajeDeError);
        }
    }
}