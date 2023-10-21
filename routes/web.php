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
use App\Http\Controllers\marcasController;
use App\Http\Controllers\modelosController;
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

Route::get('marca', function(){
    return view('vistaBackOfficeMarca');

})-> name('backoffice.marca');
Route::get('marca-modelo', function(){
    return view('vistaBackOfficeModelo');
})-> name('marca.modelo');
Route::get('/Productos', [productoController::class, 'cargarDatos'])->name('producto.cargarDatos');
Route::post('/productos', [productoController::class, 'verificarDatosAgregar'])->name('producto.Agregar');
Route::put('/productos', [productoController::class, 'verificarDatosModificar'])->name('producto.Modificar');
Route::delete('/productos', [productoController::class, 'eliminarProducto'])->name('producto.Eliminar');
Route::put('/productosr', [productoController::class, 'recuperarProducto'])->name('producto.Recuperar');


Route::get('/Almacenes', [almacenController::class, 'cargarDatos'])->name('almacen.cargarDatos');
Route::post('/almacenes', [almacenController::class, 'verificarDatosAAgregar'])->name('almacen.Agregar');
Route::put('/almacenes', [almacenController::class, 'verificarDatosAModificar'])->name('almacen.Modificar');
Route::delete('/almacenes', [almacenController::class, 'eliminarAlmacen'])->name('almacen.Eliminar');
Route::put('/almacenesr', [almacenController::class, 'recuperarAlmacen'])->name('almacen.Recuperar');


Route::get('/Destinos', [LugarEntregaController::class, 'cargarDatos'])->name('lugarEntrega.cargarDatos');
Route::post('/destinos', [LugarEntregaController::class, 'verificarDatosAgregar'])->name('lugarEntrega.Agregar');
Route::put('/destinos', [LugarEntregaController::class, ' verificarDatosModificar'])->name('lugarEntrega.Modificar');
Route::delete('/destinos', [LugarEntregaController::class, 'eliminarLugarEntrega'])->name('lugarEntrega.Eliminar');
Route::put('/destinosr', [LugarEntregaController::class, 'recuperarLugarEntrega'])->name('lugarEntrega.Recuperar');


Route::get('/Paquetes', [paqueteController::class, 'cargarDatos'])->name('paquete.cargarDatos');
Route::post('/paquetes', [paqueteController::class, ' verificarDatosAgregar'])->name('paquete.Agregar');
Route::put('/paquetes', [paqueteController::class, "verificarDatosModificar"])->name('paquete.Modificar');
Route::delete('/paquetes', [paqueteController::class, "eliminarPaquete"])->name('paquetes.Eliminar');
Route::put('/paquetesr', [paqueteController::class, "recuperarPaquete"])->name('paquete.Recuperar');

Route::get('/Lotes', [loteController::class, 'cargarDatos'])->name('lote.cargarDatos');
Route::post('/lotes', [loteController::class, 'agregarLote'])->name('lote.Agregar');
Route::delete('/lotes', [loteController::class, 'eliminarLote'])->name('lote.Eliminar');
Route::put('/lotesr', [loteController::class, "recuperarLote"])->name('lote.Recuperar');


Route::get('/Paquetes-lote', [paqueteContieneLoteController::class, 'cargarDatos'])->name('paqueteContieneLote.cargarDatos');
Route::post('/paquetes-lote', [paqueteContieneLoteController::class, 'verificarDatosAgregar'])->name('paqueteContieneLote.Agregar');
Route::put('/paquetes-lote', [paqueteContieneLoteController::class, 'verificarDatosModificar'])->name('paqueteContienLote.Modificar');
Route::delete('/paquetes-lote', [paqueteContieneLoteController::class, 'eliminarPaqueteContieneLote'])->name('paqueteContieneLote.Eliminar');
Route::put('/paquetes-loter', [paqueteContieneLoteController::class, 'recuperarPaqueteContieneLote'])->name('paqueteContienLote.Recuperar');


Route::get('/Camion-lote', [camionLlevaLoteController::class, 'cargarDatos'])->name('camionLlevaLote.cargarDatos');
Route::post('/camion-lote', [camionLlevaLoteController::class, 'verificarDatosAgregar'])->name('camionLlevaLote.Agregar');
Route::put('/camion-lote', [camionLlevaLoteController::class, 'verificarDatosModificar'])->name('camionLlevaLote.Modificar');
Route::delete('/camion-lote', [camionLlevaLoteController::class, 'eliminarCamionLlevaLote'])->name('camionLlevaLote.Eliminar');
Route::put('/camion-loter', [camionLlevaLoteController::class, 'recuperarCamionLlevaLote'])->name('camionLlevaLote.Recuperar');


Route::get('/Usuarios', [usuarioController::class, 'cargarDatos'])->name('usuario.cargarDatos');
Route::post('/usuarios', [usuarioController::class, 'verificarDatosAgregar'])->name('usuario.Agregar');
Route::put('/usuarios', [usuarioController::class, 'verificarDatosModificar'])->name('usuario.Modificar');
Route::delete('/usuarios', [usuarioController::class, 'eliminarUsuario'])->name('usuario.Eliminar');
Route::put('/usuariosr', [usuarioController::class, 'recuperarUsuario'])->name('usuario.Recuperar');


Route::get('/Telefonos', [telefonosUsuarioController::class, 'cargarDatos'])->name('telefonosUsuario.cargarDatos');
Route::post('/telefonos', [Controller::class, 'verificarDatosAgregar'])->name('telefonosUsuario.Agregar');
Route::put('/telefonos', [Controller::class, 'verificarDatosModificar'])->name('telefonosUsuario.Modificar');
Route::delete('/telefonos', [Controller::class, 'eliminarTelefonosUsuario'])->name('telefonosUsuario.Eliminar');
Route::put('/telefonosr', [Controller::class, 'recuperarTelefonosUsuario'])->name('telefonosUsuario.Recuperar');


Route::get('/Camiones', [camionesController::class, 'cargarDatos'])->name('camiones.cargarDatos');
Route::post('/camiones', [Controller::class, 'verificarDatosAgregar'])->name('camiones.Agregar');
Route::put('/camiones', [Controller::class, 'verificarDatosModificar'])->name('camiones.Modificar');
Route::delete('/camiones', [Controller::class, 'eliminarCamion'])->name('camiones.Eliminar');
Route::put('/camiones', [Controller::class, 'recuperarCamion'])->name('camiones.Recuperar');


Route::get('/Modelo', [modelosController::class, 'cargarDatos'])->name('modelos.cargarDatos');
Route::post('/modelo', [modelosController::class, 'verificarDatosAAgregar'])->name('modelo.Agregar');
Route::put('/modelo', [modelosController::class, 'verificarDatosAModificar'])->name('modelo.Modificar');
Route::delete('/modelo', [modelosController::class, 'eliminarModelo'])->name('modelo.Eliminar');
Route::put('/modelor', [modeloController::class, 'recuperarModelo'])->name('modelo.Recuperar');


Route::get('/Marca', [marcasController::class, 'cargarDatos'])->name('marcas.cargarDatos');
Route::post('/marca', [marcasController::class, 'verificarDatosAAgregar'])->name('marcas.Agregar');
Route::put('/marca', [marcasController::class, 'verificarDatosAModificar'])->name('marcas.Modificar');
Route::delete('/marca', [marcasController::class, 'eliminarMarca'])->name('marcas.Eliminar');
Route::put('/marcar', [marcasController::class, 'recuperarMarca'])->name('marcas.Recuperar');
//holaa