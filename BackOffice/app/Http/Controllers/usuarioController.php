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
        dd('no escullpi estos musculos para pelear');
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
        $tipoUsuario=$this->obtenerTipoUsuario($usuario);
        return ([
            'Id Usuario' => $usuario['id'],
            'Nombre de Usuario' => $usuario['nombre_de_usuario'],
            'Contraseña' => $usuario['contrasenia'],
            'Mail' => $mail,
            'Telefono/s' => $telefono,
            'Tipo de Usuario'=>$tipoUsuario
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
        $tiposUsuario=[];
        $administrador=Administradores::withoutTrashed()->where('id_usuarios',$usuario['id'])->get();
        $almacenero=Almaceneros::withoutTrashed()->where('id_usuarios',$usuario['id'])->get();
        $chofer=Choferes::withoutTrashed()->where('id_usuarios',$usuario['id'])->get();
        $cliente=Clientes::withoutTrashed()->where('id_usuarios',$usuario['id'])->get();
        if($administrador!=null){
            $tiposUsuario[]='Administrador';
        }
        if($almacenero!=null){
            $tiposUsuario[]='Almacenero';
        }
        if($chofer!=null){
            $tiposUsuario[]='Chofer';
        }
        if($cliente!=null){
            $tiposUsuario[]='Cliente';
        }
        return implode('/',$tiposUsuario);
    }

    private function validarDatos($usuario)
    {
        $reglas = [
            'NombreUsuario' => 'required|string|max:40',
            'Contraseña' => 'required|string|max:40',
            'Mail' => 'required|email|max:40',
        ];
        return Validator::make([
            'NombreUsuario' => $usuario['nombre'],
            'Contraseña' => $usuario['contraseña'],
            'Mail' => $usuario['mail']
        ], $reglas);
    }

    private function crearUsuario($datosUsuario)
    {
        dd('marcelo');
        $usuario = new Usuarios;
        $usuario->nombre_de_usuario = $datosUsuario['nombre'];
        $usuario->contrasenia = $datosUsuario['contraseña'];
        $usuario->save();
        $idUsuario = $usuario->getKey();
        $this->crearMailUsuario($datosUsuario, $idUsuario);
        $this->establecerTipoUsuario($datosUsuario,$idUsuario);
        if ($datosUsuario[4] == 'Administrador') {
            DB::statement("GRANT ALL PRIVILEGES ON backofficebd.* TO '{$datosUsuario['nombre']}'@'localhost' IDENTIFIED BY '{$datosUsuario['contraseña']}'");
        }
    }
    private function crearMailUsuario($usuario, $idUsuario)
    {
        $mailUsuario = new Mail_Usuarios;
        $mailUsuario->id_usuarios = $idUsuario;
        $mailUsuario->mail = $usuario['mail'];
        $mailUsuario->save();
    }

    private function establecerTipoUsuario($datoUsuario,$idUsuario){
        if($datoUsuario['administrador']){
         $administrador=new Administradores;
         $administrador->id_usuario=$idUsuario;
        }
        if($datoUsuario['almacenero']){
            $this->crearTipoUsuario($idUsuario);
            $almacenero=new Almaceneros;
            $almacenero->id_usuario=$idUsuario;
        }
        if($datoUsuario['choferes']){
            $choferes=new Choferes;
            $choferes->id_usuario=$idUsuario;
        }
        if($datoUsuario['cliente']){
            $cliente=new Clientes;
            $cliente->id_usuario=$idUsuario;
        }

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