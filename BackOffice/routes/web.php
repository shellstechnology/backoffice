<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\productoController;

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
Route::get('vistaBackOfficeProducto', function(){
    return view('vistaBackOfficeProducto');
})-> name('backoffice.producto');
Route::get('vistaBackOffice', function(){
    return view('vistaBackOffice');
})-> name('backoffice');
Route::get('/producto/cargarDatos', [productoController::class, 'cargarDatos'])->name('producto.cargarDatos');

Route::post('/producto/agregar', [productoController::class, 'agregar'])->name('producto.agregar');
Route::post('/producto/modificar', [productoController::class, 'modificar'])->name('producto.modificar');
Route::delete('/producto/eliminar', [productoController::class, 'eliminar'])->name('producto.eliminar');