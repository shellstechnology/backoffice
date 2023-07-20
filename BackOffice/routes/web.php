<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\productoController;
use App\Http\Controllers\almacenController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('vistaBackOffice');
});

Route::get('vistaBackOffice', function(){
    return view('vistaBackOffice');
})-> name('backoffice');

Route::get('vistaBackOfficeAlmacen', function(){
    return view('vistaBackOfficeAlmacen');
})-> name('backoffice.almacen');

Route::get('vistaBackOfficeProducto', function(){
    return view('vistaBackOfficeProducto');
})-> name('backoffice.producto');

Route::get('/producto/cargarDatos', [productoController::class, 'cargarDatos'])->name('producto.cargarDatos');
Route::post('/producto/agregar', [productoController::class, 'agregar'])->name('producto.agregar');
Route::post('/producto/modificar', [productoController::class, 'modificar'])->name('producto.modificar');
Route::delete('/producto/eliminar', [productoController::class, 'eliminar'])->name('producto.eliminar');
Route::post('/producto/recuperar', [productoController::class, 'recuperar'])->name('producto.recuperar');

Route::get('/almacen/cargarDatos', [productoController::class, 'cargarDatos'])->name('almacen.cargarDatos');
Route::post('/almacen/agregar', [productoController::class, 'agregar'])->name('almacen.agregar');
Route::post('/almacen/modificar', [productoController::class, 'modificar'])->name('almacen.modificar');
Route::delete('/almacen/eliminar', [productoController::class, 'eliminar'])->name('almacen.eliminar');
Route::post('/almacen/recuperar', [productoController::class, 'recuperar'])->name('almacen.recuperar');