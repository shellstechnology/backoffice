<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Administradores;
use App\Models\Almaceneros;
use App\Models\Choferes;
use App\Models\Clientes;
use App\Models\Telefonos_Usuarios;
use App\Models\Usuarios;
use App\Models\Mail_Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Validator;

class usuarioController extends Controller
{

    public function realizarAccion(Request $request)
    {
        $datosRequest = $request->all();
        if ($request->has('cbxAgregar')) {
            ;
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
        return redirect()->route('backoffice.usuarios');

    }
    public function cargarDatos()
    {
        $datoUsuario = Usuarios::withTrashed()->get();
        $infoUsuario = [];
        if ($datoUsuario) {
            foreach ($datoUsuario as $dato) {
                $infoUsuario[] = $this->definirUsuarios($dato);
            }
        }

        Session::put('usuarios', $infoUsuario);
        return redirect()->route('backoffice.usuarios');

    }

    public function agregar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            return;
        }
        $this->crearUsuario($datosRequest);

    }

    public function modificar($datosRequest)
    {

        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            return;
        }
        $this->modificarUsuario($datosRequest);
    }


    public function eliminar($datosRequest)
    {
        $id = $datosRequest['identificador'];
        Mail_Usuarios::where('id_usuarios', $id)->delete();
        Usuarios::where('id', $id)->delete();

    }

    public function recuperar($datosRequest)
    {

        $id = $datosRequest['identificador'];
        $producto = Usuarios::onlyTrashed()->find($id);
        if ($producto) {
            Usuarios::where('id', $id)->restore();
            Mail_Usuarios::where('id_usuarios', $id)->restore();
            return response()->json(['Usuario restaurado correctamente']);
        }
    }

    private function definirUsuarios($usuario)
    {
        $mail = $this->obtenerMails($usuario);
        $telefono = $this->obtenerTelefonos($usuario);
        $tipoUsuario = $this->obtenerTipoUsuario($usuario);
        return ([
            'Id Usuario' => $usuario['id'],
            'Nombre de Usuario' => $usuario['nombre_de_usuario'],
            'contrasenia' => $usuario['contrasenia'],
            'Mail' => $mail,
            'Telefono/s' => $telefono,
            'Tipo de Usuario' => $tipoUsuario,
            'created_at' => $usuario['created_at'],
            'updated_at' => $usuario['updated_at'],
            'deleted_at' => $usuario['deleted_at']
        ]);
    }

    private function obtenerMails($usuario)
    {
        $mail = Mail_Usuarios::withTrashed()->where('id_usuarios', $usuario['id'])->first();
        return $mail['mail'];
    }

    private function obtenerTelefonos($usuario)
    {
        $listaTelefonos = [];
        $telefonos = Telefonos_Usuarios::withTrashed()->where('id_usuarios', $usuario['id'])->get();
        foreach ($telefonos as $telefono) {
            $listaTelefonos[] = $telefono['telefono'];
        }
        return implode('/', $listaTelefonos);
    }

    private function obtenerTipoUsuario($usuario)
    {
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
            'mail' => $usuario['mail']
        ], $reglas);
    }

    private function crearUsuario($datosUsuario)
    {
        $mailExistente=Mail_Usuarios::withTrashed()->where('mail',$datosUsuario['mail'])->first();
        $contraseniaExistente=Usuarios::withTrashed()->where('contrasenia',$datosUsuario['contrasenia'])->first();
        if($mailExistente!=null){
            return;
        }
        if($contraseniaExistente!=null){
            return;
        }

        $usuario = new Usuarios;
        $usuario->nombre_de_usuario = $datosUsuario['nombre'];
        $usuario->contrasenia = $datosUsuario['contrasenia'];
        $usuario->save();
        $idUsuario = $usuario->getKey();
        $this->crearMailUsuario($datosUsuario, $idUsuario);
        $this->establecerTipoUsuario($datosUsuario, $idUsuario);
    }
    private function crearMailUsuario($usuario, $idUsuario)
    {
        $mailUsuario = new Mail_Usuarios;
        $mailUsuario->id_usuarios = $idUsuario;
        $mailUsuario->mail = $usuario['mail'];
        $mailUsuario->save();
    }

    private function establecerTipoUsuario($datoUsuario, $idUsuario)
    {
        if (isset($datoUsuario['usuarioAdministrador'])) {
            $administrador = new Administradores;
            $administrador->id_usuarios = $idUsuario;
            $administrador->save();
            DB::statement("GRANT ALL PRIVILEGES ON fast_tracker_db.* TO '{$datoUsuario['nombre']}'@'localhost' IDENTIFIED BY '{$datoUsuario['contrasenia']}'");
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
    }

    private function modificarUsuario($datosUsuario)
    {
        Usuarios::withTrashed()->where('Id', $datosUsuario['identificador'])->update([
            'nombre_de_usuario' => $datosUsuario['nombre'],
            'contrasenia' => $datosUsuario['contrasenia'],
        ]);
        $this->modificarMailUsuario($datosUsuario);
        $this->seleccionarTipoUsuario($datosUsuario);
    }
    private function modificarMailUsuario($usuario)
    {
        Mail_Usuarios::withTrashed()->where('id_usuarios', $usuario['identificador'])->update([
            'mail' => $usuario['mail'],
        ]);
    }

    private function seleccionarTipoUsuario($datoUsuario)
    {
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

    }

    private function modificarTipoUsuario($datoUsuario, $administrador, $almacenero, $chofer, $cliente)
    {
        switch ($administrador) {
            case 'crear':
                $datoAdministardor = Administradores::withTrashed()->updateOrCreate(['id_usuarios' => $datoUsuario['identificador']]);

                if ($datoAdministardor->trashed()) {
                    $datoAdministardor->restore();
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
    }

    private function eliminarAdministrador($datoUsuario)
    {
        $admnistrador = Administradores::withoutTrashed()->where('id_usuarios', $datoUsuario['identificador'])->first();
        if (isset($admnistrador)) {
            $admnistrador->delete();
        }
    }

    private function eliminarAlmacenero($datoUsuario)
    {
        $almacenero = Almaceneros::withoutTrashed()->where('id_usuarios', $datoUsuario['identificador'])->first();
        if (isset($almacenero)) {
            $almacenero->delete();
        }
    }

    private function eliminarCliente($datoUsuario)
    {
        $cliente = Clientes::withoutTrashed()->where('id_usuarios', $datoUsuario['identificador'])->first();
        if (isset($cliente)) {
            $cliente->delete();
        }
    }

    private function eliminarChofer($datoUsuario)
    {
        $chofer = Choferes::withoutTrashed()->where('id_usuarios', $datoUsuario['identificador'])->first();
        if (isset($chofer)) {
            $chofer->delete();
        }
    }
}