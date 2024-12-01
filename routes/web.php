<?php

use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\BultoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\InventarioController;

Route::get('/', function () {
    return view('menu');
});

Route::resource('bulto', BultoController::class);

Route::resource('venta', VentaController::class);

Route::view('/menu', 'menu')->name('menu');

Route::resource('producto',ProductoController::class);
Route::resource('cliente', ClienteController::class);
Route::resource('/proveedor', ProveedorController::class);
Route::resource('inventario', InventarioController::class);
