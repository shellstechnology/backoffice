<?php

namespace App\Http\Controllers;

use App\Models\MailUsuario;
use App\Models\TelefonosUsuario;
use App\Http\Controllers\Controller;
use App\Models\Telefonos_Usuario;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class usuarioController extends Controller
{

    public function cargarDatos()
    {
        $datoUsuario = Usuario::withTrashed()->get();
        $infoPaquete = [];
        if ($datoUsuario) {
            foreach ($datoUsuario as $dato) {
                $telefonoUsuario = TelefonosUsuario::withTrashed()->where('IdUsuario', $dato['Id'])->first();
                $mailUsuario = MailUsuario::withTrashed()->where('IdUsuario', $dato['Id'])->first();
                if ($mailUsuario) {
                    $infoPaquete[] =
                        [
                            'Id Usuario' => $dato['Id'],
                            'Nombre de Usuario' => $dato['NombreDeUsuario'],
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
        return response()->json($infoPaquete);
    }

    public function agregar(Request $request)
    {
        $datosRequest = $request->all();
        $reglas = [
            'NombreUsuario' => 'required|string|max:20',
            'Contraseña' => 'required|string|max:20',
            'TipoUsuario' => 'required|string|max:20',
            'Telefono' => 'required|string|max:9',
            'Mail' => 'required|string|max:40',
        ];
        $validador = Validator::make([
            'NombreUsuario' => $datosRequest[0],
            'Contraseña' => $datosRequest[1],
            'TipoUsuario' => $datosRequest[4],
            'Telefono' => $datosRequest[3],
            'Mail' => $datosRequest[2]
        ], $reglas);
        
        if ($validador->fails()) {
            $errores = $validador->getMessageBag();
            return response()->json(['error:' => $errores], 422);
        }
        $datosRequest = $request->all();
        $usuario = new Usuario;
        $usuario->NombreDeUsuario = $datosRequest[0];
        $usuario->Contraseña = $datosRequest[1];
        $usuario->TipoDeUsuario = $datosRequest[4];
        $usuario->save();
        $idUsuario = $usuario->getKey();
        $usuarioTelefono = new TelefonosUsuario;
        $usuarioTelefono->IdUsuario = $idUsuario;
        $usuarioTelefono->Telefono = $datosRequest[3];
        $usuarioTelefono->save();
        $mailUsuario = new MailUsuario;
        $mailUsuario->IdUsuario = $idUsuario;
        $mailUsuario->Mail = $datosRequest[2];
        $mailUsuario->save();
        if($datosRequest[4]=='Administrador'){
            DB::statement("GRANT ALL PRIVILEGES ON backofficebd.* TO '$datosRequest[0]'@'localhost' IDENTIFIED BY '$datosRequest[1]'");
        }
        return response()->json('Usuario Agregado');

    }

    public function modificar(Request $request)
    {
        try{
            $datosRequest = $request->all();
            Usuario::withTrashed()->where('Id',$datosRequest[0])->update([
                'NombreDeUsuario'=>$datosRequest[1],
                'Contraseña'=>$datosRequest[2],
                'TipoDeUsuario'=>$datosRequest[5],
            ]);
            MailUsuario::withTrashed()->where('IdUsuario',$datosRequest[0])->update([
                'Mail'=>$datosRequest[3],
            ]);
            TelefonosUsuario::withTrashed()->where('IdUsuario',$datosRequest[0])->update([
                'Telefono'=>$datosRequest[4],
            ]);
            if($datosRequest[5]=='Administrador'){
                DB::statement("GRANT ALL PRIVILEGES ON backofficebd.* TO '$datosRequest[1]'@'localhost' IDENTIFIED BY '$datosRequest[2]'");
            }else{
                DB::statement("REVOKE ALL PRIVILEGES ON backofficebd.* FROM '$datosRequest[1]'@'localhost'");
            }
            return response()->json('Usuario Modificado');

        }catch(\Exception $e){   
            return response()->json(['Error al Modificar el usuario'], 500);
        }
    }


    public function eliminar(Request $request)
    {
        $id = $request->get('identificador'); {
            try {
                TelefonosUsuario::where('IdUsuario', $id)->delete();
                MailUsuario::where('IdUsuario', $id)->delete();
                Usuario::where('Id', $id)->delete();
                return response()->json(['Usuario eliminado correctamente']);
            } catch (\Exception $e) {
                return response()->json(['Error al eliminar el usuario'], 500);
            }
        }
    }

    public function recuperar(Request $request)
    {

        $id = $request->get('identificador');
        $producto = Usuario::onlyTrashed()->find($id);
        if ($producto) {
            try {
                Usuario::where('Id', $id)->restore();
                TelefonosUsuario::where('IdUsuario', $id)->restore();
                MailUsuario::where('IdUsuario', $id)->restore();
                return response()->json(['Usuario restaurado correctamente']);
            } catch (\Exception $e) {
                return response()->json(['Error al restaurar el usuario'], 500);
            }
        } else {
            return response()->json(['El usuario no puede ser recuperado porque ya existe']);
        }
    }
}