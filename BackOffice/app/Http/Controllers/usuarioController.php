<?php

namespace App\Http\Controllers;

use App\Models\MailUsuario;
use App\Models\TelefonosUsuario;
use App\Http\Controllers\Controller;
use App\Models\Telefonos_Usuario;
use App\Models\Usuario;
use Illuminate\Http\Request;

class usuarioController extends Controller
{

    public function cargarDatos()
    {
        $datoUsuario = Usuario::withTrashed()->get();
        $infoPaquete = [];
        if ($datoUsuario) {
            foreach ($datoUsuario as $dato) {
                $telefonoUsuario = TelefonosUsuario::withTrashed()->find($dato['IdUsuario']);
                $mailUsuario = MailUsuario::withTrashed()->find($dato['IdUsuario']);
                if ($mailUsuario) {
                    $infoPaquete[] =
                        [
                            'Id Usuario' => $dato['Id'],
                            'Nombre de Usuario' => $dato['NombreUsuario'],
                            'Contraseña' => $dato['Contraseña'],
                            'Tipo de Usuario' => $dato['TipoDeUsuario'],
                            'Telefono' => $telefonoUsuario['Telefono'],
                            'Mail' => $mailUsuario['Mail'],
                            'created_at' => $dato['created_at'],
                            'updated_at' => $dato['updated_at'],
                            'deleted_at' => $dato['deleted_at'],
                        ];
                }
            }

        }
        return response()->json();
    }

    public function agregar(Request $request)
    {  
            $datosRequest = $request->all();
            $usuario = new Usuario;
            $usuario->NombreDeUsuario=$datosRequest[0];
            $usuario->Contraseña=$datosRequest[1];
            $usuario->TipoDeUsuario=$datosRequest[4];
            $usuario->save();
            $idUsuario=$usuario->getKey();
            $usuarioTelefono=new TelefonosUsuario;
            $usuarioTelefono->IdUsuario=$idUsuario;
            $usuarioTelefono->Telefono=$datosRequest[2];
            $usuarioTelefono->save();
            $mailUsuario=new MailUsuario;
            $mailUsuario->IdUsuario=$idUsuario;
            $mailUsuario->Mail=$datosRequest[3];
            return response()->json('Usuario Agregado');

    }
}