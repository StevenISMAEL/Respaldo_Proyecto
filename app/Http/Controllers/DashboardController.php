<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Venta;
use App\Models\Compra;

class DashboardController extends Controller
{
    public function Menu()
    {
        // Obtener productos recientes (últimos 5)
        $productos = Producto::latest()->take(5)->get();
    
        // Obtener ventas recientes (últimas 5)
        $ventas = Venta::with('detalles')->latest()->take(5)->get();
    
        // Obtener compras recientes (últimas 5)
        $compras = Compra::with('detalles')->latest()->take(5)->get();
    
        // Obtener ventas por mes
        $ventasPorMes = Venta::ventasPorMes()->pluck('total_venta')->toArray();
        $comprasPorMes = Compra::comprasPorMes()->pluck('total_compra')->toArray();
        
        return view('menu', compact('productos', 'ventas', 'compras', 'ventasPorMes', 'comprasPorMes'));
    }
}