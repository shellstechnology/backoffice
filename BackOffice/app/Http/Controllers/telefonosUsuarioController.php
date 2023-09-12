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
        return redirect()->route('usuarios.telefonosUsuario');
    }

    public function cargarDatos()
    {
        $infoTelefonos = [];
        $listaTelefonos = Telefonos_Usuarios::withTrashed()->get();
        foreach ($listaTelefonos as $datoTelefono) {
            $usuario = Usuarios::withTrashed()->where('id', $datoTelefono['id_usuarios'])->get();
            foreach ($usuario as $datoUsuario) {
                $infoTelefonos[] = $this->definirDatosTelefonos($datoTelefono, $datoUsuario);
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

    private function definirDatosTelefonos($datoTelefono, $datoUsuario)
    {
        return ([
            'Id del Usuario' => $datoUsuario['id'],
            'Nombre de Usuario' => $datoUsuario['nombre_de_usuario'],
            'Telefono' => $datoTelefono['telefono'],
            'Fecha de Creacion' => $datoTelefono['created_at'],
            'Ultima Actualizacion' => $datoTelefono['updated_at'],
            'Fecha de Borrado' => $datoTelefono['deleted_at']
        ]);
    }

    private function obtenerDatosUsuario($usuario)
    {
        return $usuario['id'];
    }

    public function agregar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            $errores = $validador->getMessageBag();
        }
        $this->crearTelefonoUsuario($datosRequest);
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

    public function modificar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            $errores = $validador->getMessageBag();
        }
        $this->modificarTelefonoUsuario($datosRequest);
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

    public function eliminar($datosRequest)
    {
        $telefono = Telefonos_Usuarios::withoutTrashed()->where('id_usuarios', $datosRequest['identificadorId'])
            ->where('telefono', $datosRequest['identificadorTelefono'])->first();
        if ($telefono) {
            $telefono->delete();
        }

    }

    public function recuperar($datosRequest)
    {
        $telefono = Telefonos_Usuarios::onlyTrashed()->where('id_usuarios', $datosRequest['identificadorId'])
            ->where('telefono', $datosRequest['identificadorTelefono'])->first();
        if ($telefono) {
            $telefono->restore();
        }


    }

}