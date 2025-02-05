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
use App\Http\Controllers\ConfiguracionDatosController;


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

// ✅ *Rutas accesibles por todos los usuarios autenticados*
Route::middleware('auth')->group(function () {
    Route::get('/menu', [DashboardController::class, 'menu'])->name('menu');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard')->middleware('verified');
});

// ==========================================
// ✅ *RUTAS SEPARADAS POR ROLES*
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

        // 🔹 Asegurarse de que el método create sea accesible
        Route::get('ventas/create', [VentaController::class, 'create'])->name('ventas.create')->middleware('can:crear ventas');
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
        Route::resource('ventas', VentaController::class);
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



    ////////////////////////////// esto aun no esta implementado por que toca especificar que rol o usuaio puede ingresar a estas vistas
    Route::prefix('configuracionDatos')->group(function () {
        Route::get('/', [ConfiguracionDatosController::class, 'index'])->name('configuracion_datos.index');
        Route::get('/create', [ConfiguracionDatosController::class, 'create'])->name('configuracion_datos.create');
        Route::post('/', [ConfiguracionDatosController::class, 'store'])->name('configuracion_datos.store');
        Route::get('/{id}/edit', [ConfiguracionDatosController::class, 'edit'])->name('configuracion_datos.edit');
        Route::put('/{id}', [ConfiguracionDatosController::class, 'update'])->name('configuracion_datos.update');
    });

    Route::get('/ventas/pdf/{id}', [VentaController::class, 'generarPDF'])->name('ventas.pdf');

    //////////////////////////////////

});