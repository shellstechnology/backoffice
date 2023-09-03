<?php


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
Route::post('/producto/realizarAccion', [productoController::class, 'realizarAccion'])->name('producto.realizarAccion');
Route::post('/producto/recuperar', [productoController::class, 'recuperar'])->name('producto.recuperar');

Route::get('/almacen/cargarDatos', [almacenController::class, 'cargarDatos'])->name('almacen.cargarDatos');
Route::post('/almacen/realizarAccion', [almacenController::class, 'realizarAccion'])->name('almacen.realizarAccion');

Route::get('/lugarEntrega/cargarDatos', [LugarEntregaController::class, 'cargarDatos'])->name('lugarEntrega.cargarDatos');
Route::post('/lugarEntrega/realizarAccion', [LugarEntregaController::class, 'realizarAccion'])->name('lugarEntrega.realizarAccion');
Route::post('/lugarEntrega/recuperar', [LugarEntregaController::class, 'recuperar'])->name('lugarEntrega.recuperar');

Route::get('/paquete/cargarDatos', [paqueteController::class, 'cargarDatos'])->name('paquete.cargarDatos');
Route::post('/paquete/realizarAccion', [paqueteController::class, 'realizarAccion'])->name('paquete.realizarAccion');
Route::post('/paquete/recuperar', [paqueteController::class, 'recuperar'])->name('paquete.recuperar');

Route::get('/lote/cargarDatos', [loteController::class, 'cargarDatos'])->name('lote.cargarDatos');
Route::post('/lote/realizarAccion', [loteController::class, 'realizarAccion'])->name('lote.realizarAccion');
Route::post('/lote/recuperar', [loteController::class, 'recuperar'])->name('lote.recuperar');

Route::get('/paqueteContieneLote/cargarDatos', [paqueteContieneLoteController::class, 'cargarDatos'])->name('paqueteContieneLote.cargarDatos');
Route::post('/paqueteContieneLote/realizarAccion', [paqueteContieneLoteController::class, 'realizarAccion'])->name('paqueteContieneLote.realizarAccion');
Route::post('/paqueteContieneLote/recuperar', [paqueteContieneLoteController::class, 'recuperar'])->name('paqueteContieneLote.recuperar');


Route::get('/usuario/cargarDatos', [usuarioController::class, 'cargarDatos'])->name('usuario.cargarDatos');
Route::post('/usuario/realizarAccion', [usuarioController::class, 'realizarAccion'])->name('usuario.realizarAccion');
Route::post('/usuario/recuperar', [usuarioController::class, 'recuperar'])->name('usuario.recuperar');