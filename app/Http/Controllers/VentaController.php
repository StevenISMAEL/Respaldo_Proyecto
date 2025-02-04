<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('detalles')->paginate(10);
        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('ventas.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'venta.id_ven' => 'required|string|max:15|unique:ventas,id_ven',
            'venta.cedula_cli' => 'required|string|exists:clientes,cedula_cli',
            'venta.fecha_emision_ven' => 'required|date',
            'detalles.*.codigo_pro' => 'required|string|exists:productos,codigo_pro',
            'detalles.*.cantidad_pro_detven' => 'required|integer|min:1',
            'detalles.*.precio_unitario_detven' => 'required|numeric|min:0',
            'detalles.*.iva_detven' => 'required|numeric|min:0|max:100',
            'detalles.*.tipo_venta' => 'required|string|in:UNIDAD,LIBRAS',
        ]);

        DB::beginTransaction();
        try {
            $cliente = Cliente::where('cedula_cli', $validated['venta']['cedula_cli'])->first();
            
            $venta = Venta::create([
                'id_ven' => $validated['venta']['id_ven'],
                'cedula_cli' => $validated['venta']['cedula_cli'],
                'nombre_cli_ven' => $cliente->nombre_cli, // Guardar el nombre del cliente
                'fecha_emision_ven' => $validated['venta']['fecha_emision_ven'],
                'total_ven' => 0,
            ]);

            $totalVenta = 0;

            foreach ($request->detalles as $detalle) {
                $producto = Producto::where('codigo_pro', $detalle['codigo_pro'])->first();
                $subtotal = ($detalle['precio_unitario_detven'] * $detalle['cantidad_pro_detven']) + ($detalle['precio_unitario_detven'] * $detalle['cantidad_pro_detven'] * ($detalle['iva_detven'] / 100));
                $totalVenta += $subtotal;

                $venta->detalles()->create([
                    'codigo_pro' => $detalle['codigo_pro'],
                    'cantidad_pro_detven' => $detalle['cantidad_pro_detven'],
                    'precio_unitario_detven' => $detalle['precio_unitario_detven'],
                    'iva_detven' => $detalle['iva_detven'],
                    'subtotal_detven' => $subtotal,
                    'tipo_venta' => $detalle['tipo_venta'],
                ]);
            }

            // Actualizar el total de la venta
            $venta->update(['total_ven' => $totalVenta]);

            DB::commit();

            return redirect()->route('ventas.index')->with('success', 'Venta creada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Error al guardar la venta: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $venta = Venta::with('detalles')->findOrFail($id);
        $clientes = Cliente::all();
        $productos = Producto::all();

        return view('ventas.edit', compact('venta', 'clientes', 'productos'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'venta.fecha_emision_ven' => 'required|date',
            'detalles.*.codigo_pro' => 'required|string|exists:productos,codigo_pro',
            'detalles.*.cantidad_pro_detven' => 'required|integer|min:1',
            'detalles.*.precio_unitario_detven' => 'required|numeric|min:0',
            'detalles.*.iva_detven' => 'required|numeric|min:0|max:100',
            'detalles.*.tipo_venta' => 'required|string|in:UNIDAD,LIBRAS',
        ]);

        DB::beginTransaction();
        try {
            $venta = Venta::findOrFail($id);
            $venta->update([
                'fecha_emision_ven' => $validated['venta']['fecha_emision_ven'],
            ]);

            // Eliminar los detalles anteriores
            $venta->detalles()->delete();

            $totalVenta = 0;

            foreach ($request->detalles as $detalle) {
                $producto = Producto::where('codigo_pro', $detalle['codigo_pro'])->first();
                $subtotal = ($detalle['precio_unitario_detven'] * $detalle['cantidad_pro_detven']) + ($detalle['precio_unitario_detven'] * $detalle['cantidad_pro_detven'] * ($detalle['iva_detven'] / 100));
                $totalVenta += $subtotal;

                $venta->detalles()->create([
                    'codigo_pro' => $detalle['codigo_pro'],
                    'cantidad_pro_detven' => $detalle['cantidad_pro_detven'],
                    'precio_unitario_detven' => $detalle['precio_unitario_detven'],
                    'iva_detven' => $detalle['iva_detven'],
                    'subtotal_detven' => $subtotal,
                    'tipo_venta' => $detalle['tipo_venta'],
                ]);
            }

            // Actualizar el total de la venta
            $venta->update(['total_ven' => $totalVenta]);

            DB::commit();

            return redirect()->route('ventas.index')->with('success', 'Venta actualizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Error al actualizar la venta: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $venta = Venta::findOrFail($id);
            $venta->detalles()->delete();
            $venta->delete();

            DB::commit();
            return redirect()->route('ventas.index')->with('success', 'Venta eliminada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Error al eliminar la venta: ' . $e->getMessage()]);
        }
    }
}
