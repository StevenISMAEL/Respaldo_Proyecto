<?php

use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\BultoController;
use App\Http\Controllers\VentaController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('bulto', BultoController::class);

Route::resource('venta', VentaController::class);
