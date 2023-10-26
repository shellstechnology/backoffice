<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class redireccionController extends Controller
{
    public function realizarAccionAlmacen(Request $request)
    {
        $redireccion = null;
        $accion = $request->input('accion');

        if ($accion == 'agregar') {
            $redireccion = route('almacen.Agregar', $request->all());
        } elseif ($accion == 'modificar') {
            $redireccion = 'almacen.Modificar';
        } elseif ($accion == 'eliminar') {
            $redireccion = 'almacen.Eliminar';
        } elseif ($accion == 'recuperar') {
            $redireccion = 'almacen.Recuperar';
        }

        if ($redireccion != null) {
            $datosRequest = $request->all();
            return redirect($redireccion);
        }
    }
    public function realizarAccionCamion(Request $request)
    {
        $accion = $request->input('accion');
        // Crear una instancia de Guzzle HTTP Client para realizar una solicitud POST
    
        if ($accion == 'agregar') {
            // Realizar una solicitud POST a la URL deseada
        $x= Http::post('http://localhost:8000/camiones');
        dd($x);

        } elseif ($accion == 'modificar') {
            // $client->put('http:///localhost:8000/camiones');
        } elseif ($accion == 'eliminar') {
            // $client->delete('http:///localhost:8000/camiones');
        } elseif ($accion == 'recuperar') {
            // $client->put('http:///localhost:8000/camionesr');
        }
        
        // Puedes manejar la respuesta del servidor si es necesario
        // ...
    
        // Redirigir al usuario a una página o ruta específica
        return redirect()->route('otraRuta');
    }
    

}
