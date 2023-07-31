<?php


use App\Models\Almacen;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\almacenController;
use App\Http\Controllers\lugarEntregaController;
use App\Http\Controllers\paqueteController;
use App\Http\Controllers\productoController;
use App\Http\Controllers\paqueteContieneLoteController;
use App\Http\Controllers\loteController;
use App\Http\Controllers\usuarioController;
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
Route::get('vistaBackOfficeUsuarios', function(){
    return view('vistaBackOfficeUsuarios');
})-> name('backoffice.usuarios');

Route::get('vistaBackOfficeAlmacen', function(){
    return view('vistaBackOfficeAlmacen');
})-> name('backoffice.almacen');

Route::get('vistaBackOfficeLugarEntrega', function(){
    return view('vistaBackOfficeLugarEntrega');
})-> name('almacen.lugarEntrega');

Route::get('vistaBackOfficePaquete', function(){
    return view('vistaBackOfficePaquete');
})-> name('backoffice.paquete');

Route::get('vistaBackOfficeProducto', function(){
    return view('vistaBackOfficeProducto');
})-> name('backoffice.producto');

Route::get('vistaBackOfficeLote', function(){
    return view('vistaBackOfficeLote');
})-> name('backoffice.lote');

Route::get('vistaBackOfficePaqueteContieneLote', function(){
    return view('vistaBackOfficePaqueteContieneLote');
})-> name('lote.paqueteContieneLote');


Route::get('/producto/cargarDatos', [productoController::class, 'cargarDatos'])->name('producto.cargarDatos');
Route::post('/producto/agregar', [productoController::class, 'agregar'])->name('producto.agregar');
Route::post('/producto/modificar', [productoController::class, 'modificar'])->name('producto.modificar');
Route::delete('/producto/eliminar', [productoController::class, 'eliminar'])->name('producto.eliminar');
Route::post('/producto/recuperar', [productoController::class, 'recuperar'])->name('producto.recuperar');

Route::get('/almacen/cargarDatos', [almacenController::class, 'cargarDatos'])->name('almacen.cargarDatos');
Route::post('/almacen/realizarAccion', [almacenController::class, 'realizarAccion'])->name('almacen.realizarAccion');
Route::post('/almacen/recuperar', [almacenController::class, 'recuperar'])->name('almacen.recuperar');

Route::get('/lugarEntrega/cargarDatos', [lugarEntregaController::class, 'cargarDatos'])->name('lugarEntrega.cargarDatos');
Route::post('/lugarEntrega/agregar', [lugarEntregaController::class, 'agregar'])->name('lugarEntrega.agregar');
Route::post('/lugarEntrega/modificar', [lugarEntregaController::class, 'modificar'])->name('lugarEntrega.modificar');
Route::delete('/lugarEntrega/eliminar', [lugarEntregaController::class, 'eliminar'])->name('lugarEntrega.eliminar');
Route::post('/lugarEntrega/recuperar', [lugarEntregaController::class, 'recuperar'])->name('lugarEntrega.recuperar');

Route::get('/paquete/cargarDatos', [paqueteController::class, 'cargarDatos'])->name('paquete.cargarDatos');
Route::post('/paquete/agregar', [paqueteController::class, 'agregar'])->name('paquete.agregar');
Route::post('/paquete/modificar', [paqueteController::class, 'modificar'])->name('paquete.modificar');
Route::delete('/paquete/eliminar', [paqueteController::class, 'eliminar'])->name('paquete.eliminar');
Route::post('/paquete/recuperar', [paqueteController::class, 'recuperar'])->name('paquete.recuperar');

Route::get('/lote/cargarDatos', [LoteController::class, 'cargarDatos'])->name('lote.cargarDatos');
Route::get('/lote/crearLote', [LoteController::class, 'crearLote'])->name('lote.crearLote');
Route::post('/lote/modificar', [LoteController::class, 'modificar'])->name('lote.modificar');
Route::delete('lLote/eliminar', [LoteController::class, 'eliminar'])->name('lote.eliminar');
Route::post('/lote/recuperar', [LoteController::class, 'recuperar'])->name('lote.recuperar');

Route::get('/paqueteContieneLote/cargarDatos', [paqueteContieneLoteController::class, 'cargarDatos'])->name('paqueteContieneLote.cargarDatos');
Route::post('/paqueteContieneLote/agregar', [paqueteContieneLoteController::class, 'agregar'])->name('paqueteContieneLote.agregar');
Route::post('/paqueteContieneLote/modificar', [paqueteContieneLoteController::class, 'modificar'])->name('paqueteContieneLote.modificar');
Route::delete('/paqueteContieneLote/eliminar', [paqueteContieneLoteController::class, 'eliminar'])->name('paqueteContieneLote.eliminar');
Route::post('/paqueteContieneLote/recuperar', [paqueteContieneLoteController::class, 'recuperar'])->name('paqueteContieneLote.recuperar');


Route::get('/usuario/cargarDatos', [usuarioController::class, 'cargarDatos'])->name('usuario.cargarDatos');
Route::post('/usuario/agregar', [usuarioController::class, 'agregar'])->name('usuario.agregar');
Route::post('/usuario/modificar', [usuarioController::class, 'modificar'])->name('usuario.modificar');
Route::delete('/usuario/eliminar', [usuarioController::class, 'eliminar'])->name('usuario.eliminar');
Route::post('/usuario/recuperar', [usuarioController::class, 'recuperar'])->name('usuario.recuperar');