<?php

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
use App\Http\Controllers\RoleController;

// ✅ Ruta principal (welcome)
Route::get('/', function () {
    return view('welcome');
});

// ✅ Rutas públicas para autenticación
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// ✅ Ruta única de logout 
Route::middleware('auth')->post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// ✅ **Rutas accesibles por todos los usuarios autenticados**
Route::middleware('auth')->group(function () {
    Route::get('/menu', [DashboardController::class, 'menu'])->name('menu');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard')->middleware('verified');
});

// ==========================================
// ✅ **RUTAS SEPARADAS POR ROLES**
// ==========================================

/* 📌 Rutas para ADMINISTRADOR */
Route::middleware(['auth'])->group(function () {
    Route::middleware('can:gestionar roles')->group(function () {
        Route::resource('roles', RoleController::class)->except(['show']);
    });

    Route::middleware('can:gestionar proveedores')->group(function () {
        Route::resource('proveedor', ProveedorController::class);
    });

    Route::middleware('can:ver compras')->group(function () {
        Route::resource('compras', CompraController::class);
    });

    Route::middleware('can:ver clientes')->group(function () {
        Route::resource('clientes', ClienteController::class);
    });

    Route::middleware('can:ver ventas')->group(function () {
        Route::resource('ventas', VentaController::class)->except(['destroy']);
    });
});

/* 📌 Rutas para BODEGUERO */
Route::middleware(['auth'])->group(function () {
    Route::middleware('can:ver productos')->group(function () {
        Route::resource('productos', ProductoController::class);
    });

    Route::middleware('can:ver proveedores')->group(function () {
        Route::get('proveedor', [ProveedorController::class, 'index'])->name('proveedor.index');
    });

    Route::middleware('can:ver kardex')->group(function () {
        Route::get('kardex', [KardexController::class, 'index'])->name('kardex.index');
    });
});

/* 📌 Rutas para VENDEDOR */
Route::middleware(['auth'])->group(function () {
    Route::middleware('can:ver ventas')->group(function () {
        Route::resource('ventas', VentaController::class)->except(['destroy']);
    });

    Route::middleware('can:ver clientes')->group(function () {
        Route::resource('clientes', ClienteController::class);
    });
});

/* 📌 Rutas para ADMINISTRADOR DE PROVEEDORES */
Route::middleware(['auth'])->group(function () {
    Route::middleware('can:ver proveedores')->group(function () {
        Route::resource('proveedor', ProveedorController::class);
    });

    Route::middleware('can:ver compras')->group(function () {
        Route::resource('compras', CompraController::class);
    });
});
