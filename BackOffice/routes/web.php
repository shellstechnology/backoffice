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
Route::get('vistaBackOfficeAlmacenes', function(){
    return view('vistaBackOfficeAlmacenes');
})-> name('backoffice.almacenes');
Route::post('/producto/action', [productoController::class, 'action'])->name('producto.action');