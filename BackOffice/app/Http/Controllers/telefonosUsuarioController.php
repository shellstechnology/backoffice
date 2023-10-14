<?php

namespace App\Http\Controllers;

use App\Models\Telefonos_Usuarios;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class telefonosUsuarioController extends Controller
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
                $this->eliminarTelefonosUsuario($datosRequest);
                break;
            case 'recuperar':
                $this->recuperarTelefonosUsuario($datosRequest);
                break;
        }
        ;
        $this->cargarDatos();
        return redirect()->route('usuarios.telefonosUsuario');
    }

    public function cargarDatos()
    {
        $infoTelefonos = [];
        $listaTelefonos = Telefonos_Usuarios::withTrashed()->get();
        foreach ($listaTelefonos as $datoTelefono) {
            $usuario = Usuarios::withTrashed()->where('id', $datoTelefono['id_usuarios'])->get();
            foreach ($usuario as $datoUsuario) {
                $infoTelefonos[] = $this->obtenerDatosTelefonos($datoTelefono, $datoUsuario);
            }
        }
        $infoUsuarios = [];
        $listaUsuarios = Usuarios::withoutTrashed()->get();
        foreach ($listaUsuarios as $usuario) {
            $infoUsuarios[] = $this->obtenerDatosUsuario($usuario);

        }
        Session::put('idUsuarios', $infoUsuarios);
        Session::put('telefonosUsuario', $infoTelefonos);
        return redirect()->route('usuarios.telefonosUsuario');
    }

    private function obtenerDatosTelefonos($datoTelefono, $datoUsuario)
    {
        return ([
            'Id del Usuario' => $datoUsuario['id'],
            'Nombre de Usuario' => $datoUsuario['nombre_de_usuario'],
            'Telefono' => $datoTelefono['telefono'],
            'created_at' => $datoTelefono['created_at'],
            'updated_at' => $datoTelefono['updated_at'],
            'deleted_at' => $datoTelefono['deleted_at']
        ]);
    }

    private function obtenerDatosUsuario($usuario)
    {
        return $usuario['id'];
    }

    public function verificarDatosAgregar($datosRequest)
    {
        try {
            $validador = $this->validarDatos($datosRequest);
            if ($validador->fails()) {
                $errores = $validador->getMessageBag();
            }
            $this->crearTelefonoUsuario($datosRequest);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:Debe ingresar datos para realizar esta accion';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function validarDatos($usuario)
    {
        $reglas = [
            'Id' => 'required|integer',
            'Telefono' => 'required|string|max:9',
        ];
        return Validator::make([
            'Id' => $usuario['datoUsuario'],
            'Telefono' => $usuario['telefono'],
        ], $reglas);
    }

    private function crearTelefonoUsuario($datosTelefono)
    {
        $telefono = new Telefonos_Usuarios;
        $telefono->id_usuarios = $datosTelefono['datoUsuario'];
        $telefono->telefono = $datosTelefono['telefono'];
        $telefono->save();
    }

    public function verificarDatosModificar($datosRequest)
    {
        try {
            $validador = $this->validarDatos($datosRequest);
            if ($validador->fails()) {
                $errores = $validador->getMessageBag();
            }
            $this->modificarTelefonoUsuario($datosRequest);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:Debe ingresar datos para realizar esta accion';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function modificarTelefonoUsuario($datosTelefono)
    {
        Telefonos_Usuarios::withTrashed()->where('id_usuarios', $datosTelefono['identificadorId'])
            ->where('telefono', $datosTelefono['identificadorTelefono'])
            ->update([
                'id_usuarios' => $datosTelefono['datoUsuario'],
                'telefono' => $datosTelefono['telefono']
            ]);
    }

    public function eliminarTelefonosUsuario($datosRequest)
    {
        $telefono = Telefonos_Usuarios::withoutTrashed()->where('telefono', $datosRequest['identificadorTelefono'])->first();
        if ($telefono) {
            $telefono->delete();
        }

    }

    public function recuperarTelefonosUsuario($datosRequest)
    {
        $telefono = Telefonos_Usuarios::onlyTrashed()->where('telefono', $datosRequest['identificadorTelefono'])->first();
        if ($telefono) {
            $telefono->restore();
        }
    }

}