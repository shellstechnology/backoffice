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
        try {
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
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
    }

    private function obtenerDatosTelefonos($datoTelefono, $datoUsuario)
    {
        try {
            return ([
                'Id del Usuario' => $datoUsuario['id'],
                'Nombre de Usuario' => $datoUsuario['nombre_de_usuario'],
                'Telefono' => $datoTelefono['telefono'],
                'created_at' => $datoTelefono['created_at'],
                'updated_at' => $datoTelefono['updated_at'],
                'deleted_at' => $datoTelefono['deleted_at']
            ]);
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
    }

    private function obtenerDatosUsuario($usuario)
    {
        try {
            return $usuario['id'];
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
    }

    public function verificarDatosAgregar($datosRequest)
    {
        try {
            $validador = $this->validarDatos($datosRequest);
            if ($validador->fails()) {
                $errores = $validador->getMessageBag();
                $patron = '"';
                $resultado = str_replace($patron, '', json_encode($errores->messages()));
                Session::put('respuesta', $resultado);
                return;
            }
            $this->crearTelefonoUsuario($datosRequest);
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
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
        try {
            $telefono = new Telefonos_Usuarios;
            $telefono->id_usuarios = $datosTelefono['datoUsuario'];
            $telefono->telefono = $datosTelefono['telefono'];
            $telefono->save();
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
    }

    public function verificarDatosModificar($datosRequest)
    {
        try {
            $validador = $this->validarDatos($datosRequest);
            if ($validador->fails()) {
                $errores = $validador->getMessageBag();
                $patron = '"';
                $resultado = str_replace($patron, '', json_encode($errores->messages()));
                Session::put('respuesta', $resultado);
                return;
            }
            $this->modificarTelefonoUsuario($datosRequest);
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
    }

    private function modificarTelefonoUsuario($datosTelefono)
    {
        try {
            Telefonos_Usuarios::withTrashed()->where('id_usuarios', $datosTelefono['identificadorId'])
                ->where('telefono', $datosTelefono['identificadorTelefono'])
                ->update([
                    'id_usuarios' => $datosTelefono['datoUsuario'],
                    'telefono' => $datosTelefono['telefono']
                ]);
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
    }

    public function eliminarTelefonosUsuario($datosRequest)
    {
        try {
            $telefono = Telefonos_Usuarios::withoutTrashed()->where('telefono', $datosRequest['identificadorTelefono'])->first();
            if ($telefono) {
                $telefono->delete();
            }
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
    }

    public function recuperarTelefonosUsuario($datosRequest)
    {
        try {
            $telefono = Telefonos_Usuarios::onlyTrashed()->where('telefono', $datosRequest['identificadorTelefono'])->first();
            if ($telefono) {
                $telefono->restore();
            }
        } catch (\Exception $e) {
            Session::put('respuesta', $e->getMessage());
        }
    }

}