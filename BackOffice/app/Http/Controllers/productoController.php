<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class productoController extends Controller
{
    public function cargarDatos()
    {
        $datoProducto = Producto::all();
        return response()->json($datoProducto);
    }

    public function agregar(Request $request)
    {
        // Validar los datos recibidos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|integer',
            'tipoMoneda' => 'required|string|max:255',
            'stock' => 'required|integer',
        ]);

        // Obtener los datos del formulario
        $nombre = $request->input('nombre');
        $precio = $request->input('precio');
        $tipoMoneda = $request->input('tipoMoneda');
        $stock = $request->input('stock');

        // Insertar los datos en la base de datos
        $producto = new Producto();
        $producto->nombre = $nombre;
        $producto->precio = $precio;
        $producto->tipoMoneda = $tipoMoneda;
        $producto->stock = $stock;


        // Devolver una respuesta (puedes personalizarla según tus necesidades)
        return response()->json(['mensaje' => 'Producto insertado correctamente']);
    }

    public function modificar()
    {

    }

    public function eliminar()
    {

    }
}