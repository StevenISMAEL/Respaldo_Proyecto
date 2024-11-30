<?php

use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\BultoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('bulto', BultoController::class);

Route::resource('venta', VentaController::class);

Route::view('/menu', 'menu')->name('menu');

Route::resource('producto',ProductoController::class);
Route::resource('cliente', ClienteController::class);

