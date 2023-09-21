<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\camionLlevaLoteController;
use App\Http\Controllers\almacenController;
use App\Http\Controllers\lugarEntregaController;
use App\Http\Controllers\paqueteController;
use App\Http\Controllers\productoController;
use App\Http\Controllers\paqueteContieneLoteController;
use App\Http\Controllers\loteController;
use App\Http\Controllers\usuarioController;
use App\Http\Controllers\telefonosUsuarioController;
use App\Http\Controllers\camionesController;
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

Route::get('backoffice', function(){
    return view('vistaBackOffice');
})-> name('backoffice');

Route::get('usuarios', function(){
    return view('vistaBackOfficeUsuarios');
})-> name('backoffice.usuarios');

Route::get('telefonos', function(){
    return view('vistaBackOfficeTelefonosUsuario');
})-> name('usuarios.telefonosUsuario');

Route::get('camiones', function(){
    return view('vistaBackOfficeCamiones');
})-> name('backoffice.camiones');

Route::get('camion-lote', function(){
    return view('vistaBackOfficeCamionLlevaLote');
})-> name('camion.camionLlevaLote');

Route::get('almacenes', function(){
    return view('vistaBackOfficeAlmacen');
})-> name('backoffice.almacen');

Route::get('destinos', function(){
    return view('vistaBackOfficeLugarEntrega');
})-> name('almacen.lugarEntrega');

Route::get('paquetes', function(){
    return view('vistaBackOfficePaquete');
})-> name('backoffice.paquete');

Route::get('productos', function(){
    return view('vistaBackOfficeProducto');
})-> name('backoffice.producto');

Route::get('lotes', function(){
    return view('vistaBackOfficeLote');
})-> name('backoffice.lote');

Route::get('paquete-lote', function(){
    return view('vistaBackOfficePaqueteContieneLote');
})-> name('lote.paqueteContieneLote');

Route::get('/Productos', [productoController::class, 'cargarDatos'])->name('producto.cargarDatos');
Route::post('/productos', [productoController::class, 'realizarAccion'])->name('producto.realizarAccion');
Route::post('/Productos', [productoController::class, 'recuperar'])->name('producto.recuperar');

Route::get('/Almacenes', [almacenController::class, 'cargarDatos'])->name('almacen.cargarDatos');
Route::post('/Almacenes', [almacenController::class, 'realizarAccion'])->name('almacen.realizarAccion');

Route::get('/Destinos', [LugarEntregaController::class, 'cargarDatos'])->name('lugarEntrega.cargarDatos');
Route::post('/destinos', [LugarEntregaController::class, 'realizarAccion'])->name('lugarEntrega.realizarAccion');
Route::post('/Destinos', [LugarEntregaController::class, 'recuperar'])->name('lugarEntrega.recuperar');

Route::get('/Paquetes', [paqueteController::class, 'cargarDatos'])->name('paquete.cargarDatos');
Route::post('/paquetes', [paqueteController::class, 'realizarAccion'])->name('paquete.realizarAccion');
Route::post('/Paquetes', [paqueteController::class, 'recuperar'])->name('paquete.recuperar');

Route::get('/Lotes', [loteController::class, 'cargarDatos'])->name('lote.cargarDatos');
Route::post('/lotes', [loteController::class, 'realizarAccion'])->name('lote.realizarAccion');
Route::post('/Lotes', [loteController::class, 'recuperar'])->name('lote.recuperar');

Route::get('/Paquetes-lote', [paqueteContieneLoteController::class, 'cargarDatos'])->name('paqueteContieneLote.cargarDatos');
Route::post('paquetes-lote', [paqueteContieneLoteController::class, 'realizarAccion'])->name('paqueteContieneLote.realizarAccion');
Route::post('Paquetes-lote', [paqueteContieneLoteController::class, 'recuperar'])->name('paqueteContieneLote.recuperar');

Route::get('/Camion-lote', [camionLlevaLoteController::class, 'cargarDatos'])->name('camionLlevaLote.cargarDatos');
Route::post('/camion-lote', [camionLlevaLoteController::class, 'realizarAccion'])->name('camionLlevaLote.realizarAccion');
Route::post('/Camion-lote', [camionLlevaLoteController::class, 'recuperar'])->name('camionLlevaLote.recuperar');



Route::get('/Usuarios', [usuarioController::class, 'cargarDatos'])->name('usuario.cargarDatos');
Route::post('/usuarios', [usuarioController::class, 'realizarAccion'])->name('usuario.realizarAccion');
Route::post('/Usuario', [usuarioController::class, 'recuperar'])->name('usuario.recuperar');

Route::get('/Telefonos', [telefonosUsuarioController::class, 'cargarDatos'])->name('telefonosUsuario.cargarDatos');
Route::post('/telefonos', [telefonosUsuarioController::class, 'realizarAccion'])->name('telefonosUsuario.realizarAccion');
Route::post('/Telefonos', [telefonosUsuarioController::class, 'recuperar'])->name('telefonosUsuario.recuperar');

Route::get('/Camiones', [camionesController::class, 'cargarDatos'])->name('camiones.cargarDatos');
Route::post('/camiones', [camionesController::class, 'realizarAccion'])->name('camiones.realizarAccion');
Route::post('/Camiones', [camionesController::class, 'recuperar'])->name('camiones.recuperar');
