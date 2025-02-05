<?php
use Illuminate\Support\Facades\Auth;
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
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// ✅ Ruta principal (welcome)
Route::get('/', function () {
    return view('welcome');
});

// ✅ Habilitar autenticación con verificación de email
Auth::routes(['verify' => true]);

// ✅ Rutas públicas para autenticación
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// ✅ Ruta única de logout 
Route::middleware('auth')->post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// ✅ **Rutas accesibles por todos los usuarios autenticados**
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/menu', [DashboardController::class, 'menu'])->name('menu');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ✅ Rutas de perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); // Ver perfil
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Actualizar perfil
});

// ✅ **Rutas de verificación de email**
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/dashboard');
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Se ha enviado el enlace de verificación.');
    })->middleware(['throttle:6,1'])->name('verification.send');
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

        // 🔹 Asegurar acceso a la creación de ventas
        Route::get('ventas/create', [VentaController::class, 'create'])->name('ventas.create')->middleware('can:crear ventas');
    });

    // 📌 Configuración de Datos
    Route::middleware('can:ver configuracionDatos')->group(function () {
        Route::resource('configuracion_datos', ConfiguracionDatosController::class)
            ->except(['destroy']); 
        
       
    });

    // // 📌 Rutas para configuración de datos (AÚN NO IMPLEMENTADO EN ROLES)
    // Route::prefix('configuracionDatos')->group(function () {
        
    // });

    // Route::get('/ventas/pdf/{id}', [VentaController::class, 'generarPDF'])->name('ventas.pdf');




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

    // 📌 Generación de PDF para Ventas
    Route::get('/ventas/pdf/{id}', [VentaController::class, 'generarPDF'])->name('ventas.pdf');
});
