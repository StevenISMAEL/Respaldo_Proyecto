<?php

use Spatie\Permission\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Ruta principal (welcome)
Route::get('/', function () {
    return view('welcome');
});

// Rutas públicas para autenticación
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// ✅ Ruta única de logout 
Route::middleware('auth')->post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// ✅ Rutas protegidas para admin
Route::middleware(['auth', RoleMiddleware::class.':admin'])->group(function () {   
    Route::get('/menu', [DashboardController::class, 'menu'])->name('menu');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard')->middleware('verified');

    // Perfil del usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUDs protegidos
    Route::resource('clientes', ClienteController::class);
    Route::resource('proveedor', ProveedorController::class);
    Route::resource('productos', ProductoController::class);
    Route::resource('compras', CompraController::class);
    Route::resource('kardex', KardexController::class);
    Route::resource('ventas', VentaController::class); 
});

// ✅ Rutas para bodeguero
Route::middleware(['auth', RoleMiddleware::class.':bodeguero'])->group(function () {   
    Route::resource('productos', ProductoController::class);
    Route::get('proveedor', [ProveedorController::class, 'index'])->name('proveedor.index'); 
    Route::get('kardex', [KardexController::class, 'index'])->name('kardex.index');
});

// ✅ Rutas para vendedor
Route::middleware(['auth', RoleMiddleware::class.':vendedor'])->group(function () {
    Route::resource('ventas', VentaController::class)->except(['destroy']);
    Route::resource('clientes', ClienteController::class);
});
