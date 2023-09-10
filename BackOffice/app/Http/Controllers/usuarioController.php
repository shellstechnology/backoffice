<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
            $errores = $validador->getMessageBag();
            return response()->json(['error:' => $errores], 422);
        }
        $this->crearUsuario($datosRequest);

    }

    public function modificar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            $errores = $validador->getMessageBag();
            return response()->json(['error:' => $errores], 422);
        }
        $this->modificarUsuario($datosRequest);
    }


    public function eliminar($datosRequest)
    {
        $id = $datosRequest->get('identificador');
        Mail_Usuarios::where('IdUsuario', $id)->delete();
        Usuarios::where('Id', $id)->delete();

    }

    public function recuperar($datosRequest)
    {

        $id = $datosRequest->get('identificador');
        $producto = Usuarios::onlyTrashed()->find($id);
        if ($producto) {
                Usuarios::where('Id', $id)->restore();
                Mail_Usuarios::where('IdUsuario', $id)->restore();
                return response()->json(['Usuario restaurado correctamente']);
        }
    }

    private function definirUsuarios($usuario)
    {
        $mail = $this->obtenerMails($usuario);
        $telefono = $this->obtenerTelefonos($usuario);
        $tipoUsuario=$this->obtenerTipoUsuario($usuario)
        return ([
            'Id Usuario' => $usuario['id'],
            'Nombre de Usuario' => $usuario['nombre_de_usuario'],
            'Contraseña' => $usuario['contrasenia'],
            'Mail' => $mail,
            'Telefono/s' => $telefono
        ]);
    }

    private function obtenerMails($usuario)
    {
        $mail = Mail_Usuarios::withTrashed()->where('id_usuarios',$usuario['id'])->first();
        return $mail['mail'];
    }

    private function obtenerTelefonos($usuario)
    {
        $listaTelefonos = [];
        $telefonos = Telefonos_Usuarios::withTrashed()->where('id_usuarios',$usuario['id'])->get();
        foreach ($telefonos as $telefono) {
            $listaTelefonos[] = $telefono['telefono'];
        }
        return implode('/', $listaTelefonos);
    }

    private function obtenerTipoUsuario($usuario){
        $administrador=Administrador::withTrashed->where('id_usuario',$usuario['id'])->first();
    }

    private function validarDatos($usuario)
    {
        $reglas = [
            'NombreUsuario' => 'required|string|max:20',
            'Contraseña' => 'required|string|max:20',
            'TipoUsuario' => 'required|string|max:20',
            'Mail' => 'required|mail|max:40',
        ];
        return Validator::make([
            'NombreUsuario' => $usuario['nombre'],
            'Contraseña' => $usuario['contraseña'],
            'TipoUsuario' => $usuario['tipoUsuario'],
            'Mail' => $usuario['mail']
        ], $reglas);
    }

    private function crearUsuario($datosUsuario)
    {
        $usuario = new Usuarios;
        $usuario->NombreDeUsuario = $datosUsuario['nombre'];
        $usuario->Contraseña = $datosUsuario['contraseña'];
        $usuario->TipoDeUsuario = $datosUsuario['tipoUsuario'];
        $usuario->save();
        $idUsuario = $usuario->getKey();
        $this->crearMailUsuario($datosUsuario, $idUsuario);
        if ($datosUsuario[4] == 'Administrador') {
            DB::statement("GRANT ALL PRIVILEGES ON backofficebd.* TO '{$datosUsuario['nombre']}'@'localhost' IDENTIFIED BY '{$datosUsuario['contraseña']}'");

        }
    }
    private function crearMailUsuario($usuario, $idUsuario)
    {
        $mailUsuario = new Mail_Usuarios;
        $mailUsuario->IdUsuario = $idUsuario;
        $mailUsuario->Mail = $usuario['mail'];
        $mailUsuario->save();
    }

    private function modificarUsuario($datosUsuario)
    {
        Usuarios::withTrashed()->where('Id', $datosUsuario['identificador'])->update([
            'NombreDeUsuario' => $datosUsuario['nombre'],
            'Contraseña' => $datosUsuario['contraseña'],
            'TipoDeUsuario' => $datosUsuario['tipoUsuario'],
        ]);
        $this->modificarMailUsuario($datosUsuario);
        $this->darPermisosUsuario($datosUsuario);
    }
    private function modificarMailUsuario($usuario)
    {
        Mail_Usuarios::withTrashed()->where('IdUsuario', $usuario['identificador'])->update([
            'Mail' => $usuario['mail'],
        ]);
    }

    private function darPermisosUsuario($usuario)
    {
        switch ($usuario) {
            case ('Administrador'):
                DB::statement("GRANT ALL PRIVILEGES ON backofficebd.* TO '{$usuario['nombre']}'@'localhost' IDENTIFIED BY '{$usuario['contraseña']}'");
                break;
            default:
                DB::statement("REVOKE ALL PRIVILEGES ON backofficebd.* FROM '{$usuario['nombre']}'@'localhost'");
        }

    }
}