<?php

namespace App\Http\Controllers;

use App\Models\Moneda;
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
        switch ($request->has('accion')) {
            case 'agregar':
                $this->verificarDatosAgregar($datosRequest);
                break;
            case 'modificar':
                $this->verificarDatosModificar($datosRequest);
                break;
            case 'eliminar':
                $this->eliminarProducto($datosRequest);
                break;
            case 'recuperar':
                $this->recuperarProducto($datosRequest);
                break;
        };
        $this->cargarDatos();
        return redirect()->route('backoffice.producto');
    }
    public function cargarDatos()
    {
        $datoProducto = Producto::withTrashed()->get();
        $infoProducto = [];
        $infoMonedas = [];
        if ($datoProducto) {
            foreach ($datoProducto as $dato) {
                $infoProducto[] = $this->obtenerProducto($dato);
            }
        }
        $infoMonedas = $this->obtenerMonedas();
        Session::put('monedas', $infoMonedas);
        Session::put('producto', $infoProducto);
        return redirect()->route('backoffice.producto');
    }

    public function verificarDatosAgregar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            return;
        }
        $this->crearProducto($datosRequest);
    }

    public function verificarDatosModificar($datosRequest)
    {
        $validador = $this->validarDatos($datosRequest);
        if ($validador->fails()) {
            return;
        }
        $this->modificarProducto($datosRequest);
    }

    public function eliminarProducto($datosRequest)
    {
        $producto = Producto::withoutTrashed()->where('id', $datosRequest['identificador'])->first();
        if ($producto) {
            $producto->delete();
        }
    }

    public function recuperarProducto($datosRequest)
    {
        $producto = Producto::onlyTrashed()->where('id', $datosRequest['identificador'])->first();
        if ($producto) {
            $producto->restore();
        }
    }

    private function obtenerProducto($producto)
    {
        $moneda = Moneda::withTrashed()->where('id', $producto['id_moneda'])->first();
        return ([
            'Id' => $producto['id'],
            'Nombre' => $producto['nombre'],
            'Stock' => $producto['stock'],
            'Precio' => $producto['precio'],
            'Moneda' => $moneda['moneda'],
            'created_at' => $producto['created_at'],
            'updated_at' => $producto['updated_at'],
            'deleted_at' => $producto['deleted_at']
        ]);

    }

    private function obtenerMonedas()
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
            'Nombre' => 'required|string|max:50',
            'Precio' => 'required|integer|min:1|max:99999999',
            'Moneda' => 'required|string|max:30',
            'Stock' => 'required|integer|min:0|max:999999',
        ];
        return Validator::make([
            'Nombre' => $producto['nombre'],
            'Precio' => $producto['precio'],
            'Moneda' => $producto['tipoMoneda'],
            'Stock' => $producto['stock'],
        ], $reglas);
    }

    private function crearProducto($producto)
    {
        $moneda = $this->obtenerMoneda($producto['tipoMoneda']);
        $nuevoProducto = new Producto;
        $nuevoProducto->nombre = $producto['nombre'];
        $nuevoProducto->precio = $producto['precio'];
        $nuevoProducto->id_moneda = $moneda;
        $nuevoProducto->stock = $producto['stock'];
        $nuevoProducto->save();
    }

    private function obtenerMoneda($producto)
    {
        $datosMoneda = Moneda::withTrashed()->where('moneda', $producto)->first();
        $moneda = $datosMoneda['id'];
        return $moneda;
    }

    private function modificarProducto($producto)
    {
        $moneda = $this->obtenerMoneda($producto['tipoMoneda']);
        Producto::where('id', $producto['identificador'])->update([
            'nombre' => $producto['nombre'],
            'precio' => $producto['precio'],
            'id_moneda' => $moneda,
            'stock' => $producto['stock'],
        ]);
    }
}