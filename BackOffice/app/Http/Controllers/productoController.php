<?php

namespace App\Http\Controllers;

use App\Models\moneda;
use App\Models\Productos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class productoController extends Controller
{
    public function cargarDatos()
    {
        $datoProducto = Productos::withTrashed()->get();
        $infoPaquete = [];
        if ($datoProducto) {
            foreach ($datoProducto as $dato) {
                $infoPaquete[] = $this->definirProducto($dato);
            }
        }
        Session::put('paquete', $infoPaquete);
        return redirect()->route('backoffice.paquete');
    }

    public function agregar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            $errores = $validador->getMessageBag();
            return response()->json(['error:' => $errores], 422);
        }
        $this->definirProducto($datosRequest);
    }

    public function modificar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            $errores = $validador->getMessageBag();
            return response()->json(['error:' => $errores], 422);
        }
        $this->modificarProducto($datosRequest);
    }

    public function eliminar($datosRequest)
    {
        $id = $datosRequest->get('identificador');
        $producto = Productos::withoutTrashed()->where('id', $id)->first();
        if ($producto) {
            $producto->delete();
        }
    }

    public function recuperar($datosRequest)
    {
        $id = $datosRequest->get('identificador');
        $producto = Productos::onlyTrashed()->where('id', $id)->first();
        if ($producto) {
            $producto->restore();
        }
    }

    private function definirProducto($producto)
    {
        $moneda = moneda::withTrashed()->where('id', 'id_moneda')->first();
        return ([
            'Nombre' => $producto['nombre'],
            'Stock' => $producto['stock'],
            'Precio' => $producto['precio'],
            'Moneda' => $moneda['moneda']
        ]);

    }

    private function validarDatos($producto)
    {
        $reglas = [
            'Nombre' => 'required|string|max:20',
            'Precio' => 'required|integer|min:1|max:9999999',
            'TipoMoneda' => 'required|string|max:3',
            'Stock' => 'required|integer|min:0|max:9999999',
        ];
        return Validator::make([
            'Nombre' => $producto['caracteristica'],
            'Precio' => $producto['nombreRemitente'],
            'TipoMoneda' => $producto['nombreDestiatario'],
            'Stock' => $producto['volumen'],
        ], $reglas);
    }

    private function modificarProducto($producto)
    {
        Productos::where('id', $producto['identificador'])->update([
            'Nombre' => $producto['identificador'],
            'Precio' => $producto['precio'],
            'TipoMoneda' => $producto['tipoMoneda'],
            'Stock' => $producto['stock'],
        ]);
    }
}