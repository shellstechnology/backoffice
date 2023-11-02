<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class redireccionController extends Controller
{
    public function agregarAlmacen($request)
    {
        $data=[
            "idLugarEntrega"=> $request->input("idLugarEntrega"),
        ];
        return $this->app->call('App\Http\Controllers\ControladorB@recibirDatos', ['data' => $data]);
        

    }

    public function modificarAlmacen($request)
    {
        Http::put('http://127.0.0.1:8007/almacenes', [
            'idLugarEntrega' => $request->input('idLugarEntrega'),
        ]);
        return redirect()->route('backoffice.almacen');
    }

    public function eliminarAlmacen($request)
    {
        Http::delete('http://127.0.0.1:8007/almacenes', [
            'idLugarEntrega' => $request->input('idLugarEntrega'),
        ]);
        return redirect()->route('backoffice.almacen');
    }
    public function recuperarAlmacen($request)
    {
        Http::patch('http://127.0.0.1:8007/almacenes', [
            'idLugarEntrega' => $request->input('idLugarEntrega'),
        ]);
        return redirect()->route('backoffice.almacen');
    }


    public function redireccionAlmacenes(Request $request)
    {
        $accion = $request->input('accion');
        if ($accion == 'agregar') {
            $this->agregarAlmacen($request);
        }
        if ($accion == 'modificar') {
            $this->modificarAlmacen($request);
        }
        if ($accion == 'eliminar') {
            $this->eliminarAlmacen($request);
        }
        if ($accion == 'recuperar') {
            $this->recuperarAlmacen($request);
        }
        return redirect()->route('backoffice.almacen');
    }
}
