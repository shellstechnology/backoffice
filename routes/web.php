<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Request;
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
use App\Http\Controllers\marcasController;
use App\Http\Controllers\modelosController;
use App\Http\Controllers\monedaController;
use App\Http\Controllers\loginController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/login', function () {
    return view('login');
});

Route::post('/login1', [loginController::class, 'iniciarSesion'])->name('login');
Route::get('/login1', [loginController::class, 'Logout'])->name('logout');

Route::get('/', function () {
    return view('vistaBackOffice');
})->middleware(Autenticacion::class);

Route::get('backoffice', function(){
    return view('vistaBackOffice');
})-> name('backoffice')->middleware(Autenticacion::class);

Route::get('usuarios', function(){
    return view('vistaBackOfficeUsuarios');
})-> name('backoffice.usuarios')->middleware(Autenticacion::class);

Route::get('telefonos', function(){
    return view('vistaBackOfficeTelefonosUsuario');
})-> name('usuarios.telefonosUsuario')->middleware(Autenticacion::class);

Route::get('camiones', function(){
    return view('vistaBackOfficeCamiones');
})-> name('backoffice.camiones')->middleware(Autenticacion::class);

Route::get('camion-lote', function(){
    return view('vistaBackOfficeCamionLlevaLote');
})-> name('camion.camionLlevaLote')->middleware(Autenticacion::class);

Route::get('almacenes', function(){
    return view('vistaBackOfficeAlmacen');
})-> name('backoffice.almacen')->middleware(Autenticacion::class);

Route::get('destinos', function(){
    return view('vistaBackOfficeLugarEntrega');
})-> name('almacen.lugarEntrega')->middleware(Autenticacion::class);

Route::get('paquetes', function(){
    return view('vistaBackOfficePaquete');
})-> name('backoffice.paquete')->middleware(Autenticacion::class);

Route::get('productos', function(){
    return view('vistaBackOfficeProducto');
})-> name('backoffice.producto')->middleware(Autenticacion::class);

Route::get('lotes', function(){
    return view('vistaBackOfficeLote');
})-> name('backoffice.lote')->middleware(Autenticacion::class);

Route::get('paquete-lote', function(){
    return view('vistaBackOfficePaqueteContieneLote');
})-> name('lote.paqueteContieneLote')->middleware(Autenticacion::class);

Route::get('marca', function(){
    return view('vistaBackOfficeMarca');
})-> name('backoffice.marca')->middleware(Autenticacion::class);

Route::get('marca-modelo', function(){
    return view('vistaBackOfficeModelo');
})-> name('marca.modelo')->middleware(Autenticacion::class);


Route::get('moneda', function(){
    return view('vistaBackOfficeMoneda');
})-> name('backoffice.moneda');

Route::get('/Productos', [productoController::class, 'cargarDatos'])->name('producto.cargarDatos')->middleware(Autenticacion::class);
Route::post('/productos', [productoController::class, 'realizarAccion'])->name('producto.realizarAccion')->middleware(Autenticacion::class);
Route::post('/Productos', [productoController::class, 'recuperar'])->name('producto.recuperar')->middleware(Autenticacion::class);

Route::get('/Almacenes', [almacenController::class, 'cargarDatos'])->name('almacen.cargarDatos')->middleware(Autenticacion::class);
Route::post('/Almacenes', [almacenController::class, 'realizarAccion'])->name('almacen.realizarAccion')->middleware(Autenticacion::class);

Route::get('/Destinos', [LugarEntregaController::class, 'cargarDatos'])->name('lugarEntrega.cargarDatos')->middleware(Autenticacion::class);
Route::post('/destinos', [LugarEntregaController::class, 'realizarAccion'])->name('lugarEntrega.realizarAccion')->middleware(Autenticacion::class);
Route::post('/Destinos', [LugarEntregaController::class, 'recuperar'])->name('lugarEntrega.recuperar')->middleware(Autenticacion::class);

Route::get('/Paquetes', [paqueteController::class, 'cargarDatos'])->name('paquete.cargarDatos')->middleware(Autenticacion::class);
Route::post('/paquetes', [paqueteController::class, 'realizarAccion'])->name('paquete.realizarAccion')->middleware(Autenticacion::class);
Route::post('/Paquetes', [paqueteController::class, 'recuperar'])->name('paquete.recuperar')->middleware(Autenticacion::class);

Route::get('/Lotes', [loteController::class, 'cargarDatos'])->name('lote.cargarDatos')->middleware(Autenticacion::class);
Route::post('/lotes', [loteController::class, 'realizarAccion'])->name('lote.realizarAccion')->middleware(Autenticacion::class);
Route::post('/Lotes', [loteController::class, 'recuperar'])->name('lote.recuperar')->middleware(Autenticacion::class);

Route::get('/Paquetes-lote', [paqueteContieneLoteController::class, 'cargarDatos'])->name('paqueteContieneLote.cargarDatos')->middleware(Autenticacion::class);
Route::post('paquetes-lote', [paqueteContieneLoteController::class, 'realizarAccion'])->name('paqueteContieneLote.realizarAccion')->middleware(Autenticacion::class);
Route::post('Paquetes-lote', [paqueteContieneLoteController::class, 'recuperar'])->name('paqueteContieneLote.recuperar')->middleware(Autenticacion::class);

Route::get('/Camion-lote', [camionLlevaLoteController::class, 'cargarDatos'])->name('camionLlevaLote.cargarDatos')->middleware(Autenticacion::class);
Route::post('/camion-lote', [camionLlevaLoteController::class, 'realizarAccion'])->name('camionLlevaLote.realizarAccion')->middleware(Autenticacion::class);
Route::post('/Camion-lote', [camionLlevaLoteController::class, 'recuperar'])->name('camionLlevaLote.recuperar')->middleware(Autenticacion::class);



Route::get('/Usuarios', [usuarioController::class, 'cargarDatos'])->name('usuario.cargarDatos')->middleware(Autenticacion::class);
Route::post('/usuarios', [usuarioController::class, 'realizarAccion'])->name('usuario.realizarAccion')->middleware(Autenticacion::class);
Route::post('/Usuario', [usuarioController::class, 'recuperar'])->name('usuario.recuperar')->middleware(Autenticacion::class);

Route::get('/Telefonos', [telefonosUsuarioController::class, 'cargarDatos'])->name('telefonosUsuario.cargarDatos')->middleware(Autenticacion::class);
Route::post('/telefonos', [telefonosUsuarioController::class, 'realizarAccion'])->name('telefonosUsuario.realizarAccion')->middleware(Autenticacion::class);
Route::post('/Telefonos', [telefonosUsuarioController::class, 'recuperar'])->name('telefonosUsuario.recuperar')->middleware(Autenticacion::class);

Route::get('/Camiones', [camionesController::class, 'cargarDatos'])->name('camiones.cargarDatos')->middleware(Autenticacion::class);
Route::post('/camiones', [camionesController::class, 'realizarAccion'])->name('camiones.realizarAccion')->middleware(Autenticacion::class);
Route::post('/Camiones', [camionesController::class, 'recuperar'])->name('camiones.recuperar')->middleware(Autenticacion::class);

Route::get('/Marca', [marcasController::class, 'cargarDatos'])->name('marcas.cargarDatos')->middleware(Autenticacion::class);
Route::post('/marca', [marcasController::class, 'realizarAccion'])->name('marcas.realizarAccion')->middleware(Autenticacion::class);
Route::post('/Marca', [marcasController::class, 'recuperar'])->name('marcas.recuperar')->middleware(Autenticacion::class);

Route::get('/Modelo', [modelosController::class, 'cargarDatos'])->name('modelos.cargarDatos')->middleware(Autenticacion::class);
Route::post('/modelo', [modelosController::class, 'realizarAccion'])->name('modelos.realizarAccion')->middleware(Autenticacion::class);
Route::post('/Modelo', [modelosController::class, 'recuperar'])->name('modelos.recuperar')->middleware(Autenticacion::class);

Route::get('/Moneda', [monedaController::class, 'cargarDatos'])->name('moneda.cargarDatos')->middleware(Autenticacion::class);
Route::post('/moneda', [monedaController::class, 'realizarAccion'])->name('moneda.realizarAccion')->middleware(Autenticacion::class);
Route::post('/Moneda', [monedaController::class, 'recuperar'])->name('moneda.recuperar')->middleware(Autenticacion::class);

