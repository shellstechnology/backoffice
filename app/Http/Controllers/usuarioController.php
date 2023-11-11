<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\administradores;
use App\Models\almaceneros;
use App\Models\choferes;
use App\Models\clientes;
use App\Models\telefonos_usuarios;
use App\Models\usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class usuarioController extends Controller
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
                $this->eliminarUsuario($datosRequest);
                break;
            case 'recuperar':
                $this->recuperarUsuario($datosRequest);
                break;
        }
        return redirect()->route('backoffice.usuarios');

    }
    public function cargarDatos()
    {
        try {
            $datoUsuario = Usuarios::withTrashed()->get();
            $infoUsuario = [];
            if ($datoUsuario) {
                foreach ($datoUsuario as $dato) {
                    $infoUsuario[] = $this->obtenerUsuarios($dato);
                }
            }

            Session::put('usuarios', $infoUsuario);
            return redirect()->route('backoffice.usuarios');
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
                $errores = $validador->getMessageBag();
                Session::put('respuesta', json_encode($errores->messages()));
                return;
            }
            $this->crearUsuario($datosRequest);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:Debe ingresar datos para realizar esta accion';
            Session::put('respuesta', $mensajeDeError);
        }

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
            $this->modificarUsuario($datosRequest);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:Debe ingresar datos para realizar esta accion';
            Session::put('respuesta', $mensajeDeError);
        }
    }


    public function eliminarUsuario($datosRequest)
    {
        try {
            $id = $datosRequest['identificador'];
            Usuarios::where('id', $id)->delete();
            $mensajeConfirmacion = 'Usuario eliminado exitosamente';
            Session::put('respuesta', $mensajeConfirmacion);
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: ';
            Session::put('respuesta', $mensajeDeError);
        }

    }

    public function recuperarUsuario($datosRequest)
    {
        try {
            $id = $datosRequest['identificador'];
            $usuario = Usuarios::onlyTrashed()->where('id',$id)->first();
            if ($usuario) {
                Usuarios::where('id', $id)->restore();
                $mensajeConfirmacion = 'Usuario restaurado exitosamente';
                Session::put('respuesta', $mensajeConfirmacion);
            }
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: ';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function obtenerUsuarios($usuario)
    {
        try {
            $telefono = $this->obtenerTelefonos($usuario);
            $tipoUsuario = $this->obtenerTipoUsuario($usuario);
            return ([
                'Id Usuario' => $usuario['id'],
                'Nombre de Usuario' => $usuario['name'],
                'contrasenia' => $usuario['password'],
                'Mail' => $usuario['email'],
                'Telefono/s' => $telefono,
                'Tipo de Usuario' => $tipoUsuario,
                'created_at' => $usuario['created_at'],
                'updated_at' => $usuario['updated_at'],
                'deleted_at' => $usuario['deleted_at']
            ]);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: ';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function obtenerTelefonos($usuario)
    {
        try {
            $listaTelefonos = [];
            $telefonos = Telefonos_Usuarios::withTrashed()->where('id_usuarios', $usuario['id'])->get();
            foreach ($telefonos as $telefono) {
                $listaTelefonos[] = $telefono['telefono'];
            }
            return implode('/', $listaTelefonos);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: ';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function obtenerTipoUsuario($usuario)
    {
        try {
            $tiposUsuario = [];
            $administrador = Administradores::withoutTrashed()->where('id_usuarios', $usuario['id'])->first();
            $almacenero = Almaceneros::withoutTrashed()->where('id_usuarios', $usuario['id'])->first();
            $chofer = Choferes::withoutTrashed()->where('id_usuarios', $usuario['id'])->first();
            $cliente = Clientes::withoutTrashed()->where('id_usuarios', $usuario['id'])->first();

            if ($administrador) {
                $tiposUsuario[] = 'Administrador';
            }
            if ($almacenero) {
                $tiposUsuario[] = 'Almacenero';
            }
            if ($chofer) {
                $tiposUsuario[] = 'Chofer';
            }
            if ($cliente) {
                $tiposUsuario[] = 'Cliente';
            }

            return implode('/', $tiposUsuario);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: ';
            Session::put('respuesta', $mensajeDeError);
        }
    }


    private function validarDatos($usuario)
    {
        $reglas = [
            'nombreUsuario' => 'required|string|max:50',
            'contrasenia' => 'required|string|max:25',
            'mail' => 'required|email|max:50',

        ];
        return Validator::make([
            'nombreUsuario' => $usuario['nombre'],
            'contrasenia' => $usuario['contrasenia'],
            'mail' => $usuario['mail'],

        ], $reglas);
    }
    private function crearUsuario($datosUsuario)
    {
        try {
            $checkboxSeleccionada = $this->verificarCheckboxTipoUsuario($datosUsuario);
            if ($checkboxSeleccionada != true) {
                return;
            }
            $contraseniaExistente = Usuarios::withTrashed()->where('password', $datosUsuario['contrasenia'])->first();
            if ($contraseniaExistente != null) {
                return;
            }

            $user = new usuarios();
            $user->name = $datosUsuario['nombre'];
            $user->email = $datosUsuario['mail'];
            $user->password = Hash::make($datosUsuario['contrasenia']);
            $user->save();
            $this->establecerTipoUsuario($datosUsuario, $user);
            $mensajeConfirmacion = 'Usuario creado exitosamente';
            Session::put('respuesta', $mensajeConfirmacion);
            $this->cargarDatos();
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: ';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function establecerTipoUsuario($datoUsuario, $idUsuario)
    {
        try {
            if (isset($datoUsuario['usuarioAdministrador'])) {
                $administrador = new Administradores;
                $administrador->id_usuarios = $idUsuario;
                $administrador->save();
            }
            if (isset($datoUsuario['usuarioAlmacenero'])) {
                $almacenero = new Almaceneros;
                $almacenero->id_usuarios = $idUsuario;
                $almacenero->save();
            }
            if (isset($datoUsuario['usuarioChofer'])) {
                $choferes = new Choferes;
                $choferes->id_usuarios = $idUsuario;
                $choferes->save();
            }
            if (isset($datoUsuario['usuarioCliente'])) {
                $cliente = new Clientes;
                $cliente->id_usuarios = $idUsuario;
                $cliente->save();
            }
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: ';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function modificarUsuario($datosUsuario)
    {
        try {
            $checkboxSeleccionada = $this->verificarCheckboxTipoUsuario($datosUsuario);
            if ($checkboxSeleccionada != true) {
                return;
            }
            Usuarios::withTrashed()->where('Id', $datosUsuario['identificador'])->update([
                'name' => $datosUsuario['nombre'],
                'email'=>$datosUsuario['mail'],
                'password' => Hash::make($datosUsuario['contrasenia']),
            ]);
            $this->seleccionarTipoUsuario($datosUsuario);
            $mensajeConfirmacion = 'Usuario modificado exitosamente';
            Session::put('respuesta', $mensajeConfirmacion);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: ';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function seleccionarTipoUsuario($datoUsuario)
    {
        try {
            $administrador = null;
            $almacenero = null;
            $chofer = null;
            $cliente = null;
            if (isset($datoUsuario['usuarioAdministrador'])) {
                $administrador = 'crear';
            }
            if (isset($datoUsuario['usuarioAlmacenero'])) {
                $almacenero = 'crear';
            }
            if (isset($datoUsuario['usuarioChofer'])) {
                $chofer = 'crear';
            }
            if (isset($datoUsuario['usuarioCliente'])) {
                $cliente = 'crear';
            }
            $this->modificarTipoUsuario($datoUsuario, $administrador, $almacenero, $chofer, $cliente);
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: ';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function modificarTipoUsuario($datoUsuario, $administrador, $almacenero, $chofer, $cliente)
    {
        try {
            switch ($administrador) {
                case 'crear':
                    $datoAdministador = Administradores::withTrashed()->updateOrCreate(['id_usuarios' => $datoUsuario['identificador']]);
                    $datoAdministador->save();
                    if ($datoAdministador->trashed()) {
                        $datoAdministador->restore();
                    }
                    break;
                default:
                    $this->eliminarAdministrador($datoUsuario);

            }

            switch ($almacenero) {
                case 'crear':
                    $datoAlmacenero = Almaceneros::withTrashed()->updateOrCreate(['id_usuarios' => $datoUsuario['identificador']]);

                    if ($datoAlmacenero->trashed()) {
                        $datoAlmacenero->restore();
                    }
                    break;
                default:
                    $this->eliminarAlmacenero($datoUsuario);

            }

            switch ($chofer) {
                case 'crear':
                    $datoChofer = Choferes::withTrashed()->updateOrCreate(['id_usuarios' => $datoUsuario['identificador']]);

                    if ($datoChofer->trashed()) {
                        $datoChofer->restore();
                    }
                    break;
                default:
                    $this->eliminarChofer($datoUsuario);

            }

            switch ($cliente) {
                case 'crear':
                    $datoCliente = Clientes::withTrashed()->updateOrCreate(['id_usuarios' => $datoUsuario['identificador']]);
                    if ($datoCliente->trashed()) {
                        $datoCliente->restore();
                    }
                    break;
                default:
                    $this->eliminarCliente($datoUsuario);

            }
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: ';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function eliminarAdministrador($datoUsuario)
    {
        try {
            $admnistrador = Administradores::withoutTrashed()->where('id_usuarios', $datoUsuario['identificador'])->first();
            if (isset($admnistrador)) {
                $admnistrador->delete();
            }
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: ';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function eliminarAlmacenero($datoUsuario)
    {
        try {
            $almacenero = Almaceneros::withoutTrashed()->where('id_usuarios', $datoUsuario['identificador'])->first();
            if (isset($almacenero)) {
                $almacenero->delete();
            }
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: ';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function eliminarCliente($datoUsuario)
    {
        try {
            $cliente = Clientes::withoutTrashed()->where('id_usuarios', $datoUsuario['identificador'])->first();
            if (isset($cliente)) {
                $cliente->delete();
            }
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: ';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function eliminarChofer($datoUsuario)
    {
        try {
            $chofer = Choferes::withoutTrashed()->where('id_usuarios', $datoUsuario['identificador'])->first();
            if (isset($chofer)) {
                $chofer->delete();
            }
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: ';
            Session::put('respuesta', $mensajeDeError);
        }
    }

    private function verificarCheckboxTipoUsuario($datosUsuario)
    {
        try {
            $checkboxes = ['usuarioAdministrador', 'usuarioAlmacenero', 'usuarioChofer', 'usuarioCliente'];
            foreach ($checkboxes as $checkbox) {
                if (isset($datosUsuario[$checkbox]) && $datosUsuario[$checkbox] === 'on') {
                    return true;
                }
            }
            return false;
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: ';
            Session::put('respuesta', $mensajeDeError);
        }
    }

}