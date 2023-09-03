<?php

namespace App\Http\Controllers;

use App\Models\moneda;
use App\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class productoController extends Controller
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
             return redirect()->route('backoffice.producto');
    }
    public function cargarDatos()
    {
        $datoProducto = Producto::withTrashed()->get();
        $infoProducto = [];
        $infoMonedas = [];
        if ($datoProducto) {
            foreach ($datoProducto as $dato) {
                $infoProducto[] = $this->definirProducto($dato);
            }
        }
        $infoMonedas = $this->definirMonedas();
        Session::put('monedas', $infoMonedas);
        Session::put('producto', $infoProducto);
        return redirect()->route('backoffice.producto');
    }

    public function agregar($datosRequest)
    { {
            try {
                $validador = $this->validarDatos($datosRequest);
                dd('a');
                if ($validador->fails()) {
                    $errores = $validador->getMessageBag();
                    Session::put('respuesta', ('Error al ingresar los datos,' + $errores));
                    return redirect()->route('backoffice.producto');
                }

                $this->crearProducto($datosRequest);
            }catch(\Exception $e){
                Session::put('respuesta', ('Se a producido un error inesperado:'));
            }
        }
    }

    public function modificar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            $errores = $validador->getMessageBag();
            Session::put('respuesta', ('Error al modificar los datos,' + $errores));
            return redirect()->route('backoffice.producto');
        }
        $this->modificarProducto($datosRequest);
    }

    public function eliminar($datosRequest)
    {
        $id = $datosRequest->get('identificador');
        $producto = Producto::withoutTrashed()->where('id', $id)->first();
        if ($producto) {
            $producto->delete();
        }
    }

    public function recuperar($datosRequest)
    {
        $id = $datosRequest->get('identificador');
        $producto = Producto::onlyTrashed()->where('id', $id)->first();
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

    private function definirMonedas()
    {
        $infoMonedas = [];
        $monedas = moneda::withTrashed()->get();
        if ($monedas) {
            foreach ($monedas as $datoMoneda) {
                $infoMonedas[] = $datoMoneda['moneda'];
            }
        }
        return $infoMonedas;
    }

    private function validarDatos($producto)
    {
        $reglas = [
            'Nombre' => 'required|string|max:20',
            'Precio' => 'required|integer|min:1|max:9999999',
            'TipoMoneda' => 'required|string|max:20',
            'Stock' => 'required|integer|min:0|max:9999999',
        ];
        return Validator::make([
            'Nombre' => $producto['nombre'],
            'Precio' => $producto['precio'],
            'TipoMoneda' => $producto['tipoMoneda'],
            'Stock' => $producto['stock'],
        ], $reglas);
    }

    private function crearProducto($producto)
    { {
            try {
                $nuevoProducto = new Producto;
                $nuevoProducto->nombre = $producto['nombre'];
                $nuevoProducto->precio = $producto['precio'];
                $nuevoProducto->tipoMoneda = $producto['tipoMoneda'];
                $nuevoProducto->stock = $producto['stock'];
                $nuevoProducto->save();
                Session::put('respuesta', 'Producto creado correctamente');
            } catch (\Exception $e) {
                Session::put('respuesta', ('Error al agregar el producto,' + $e));

            }

        }
    }

    private function modificarProducto($producto)
    {
        Producto::where('id', $producto['identificador'])->update([
            'Nombre' => $producto['identificador'],
            'Precio' => $producto['precio'],
            'TipoMoneda' => $producto['tipoMoneda'],
            'Stock' => $producto['stock'],
        ]);
    }
}