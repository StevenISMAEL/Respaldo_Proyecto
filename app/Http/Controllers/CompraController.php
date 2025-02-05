<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Kardex;
use App\Models\Lote;

class CompraController extends Controller
{
    public function index(Request $request)
    {
        // Obtiene el término de búsqueda si existe
        $search = $request->query('search');

        // Consulta de compras con filtro si hay búsqueda
        $compras = Compra::when($search, function ($query) use ($search) {
            return $query->where('id_com', 'ILIKE', "%{$search}%")
                         ->orWhere('ruc_pro', 'ILIKE', "%{$search}%");
        })->orderBy('fecha_emision_com', 'desc')->paginate(10);

        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        return view('compras.create', compact('proveedores', 'productos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'compra.id_com' => 'required|string|max:15|unique:compras,id_com',
            'compra.ruc_pro' => 'required|string|exists:proveedores,ruc_pro',
            'compra.fecha_emision_com' => 'required|date',
            'detalles.*.codigo_pro' => 'required|string|exists:productos,codigo_pro',
            'detalles.*.cantidad_pro_detcom' => 'required|integer|min:1',
            'detalles.*.precio_unitario_com' => 'required|numeric|min:0',
            'detalles.*.iva_detcom' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Guardar la compra
            $compra = Compra::create([
                'id_com' => $validated['compra']['id_com'],
                'ruc_pro' => $validated['compra']['ruc_pro'],
                'fecha_emision_com' => $validated['compra']['fecha_emision_com'],
                'total_com' => 0, // Se calculará más adelante
            ]);

            $totalCompra = 0;

            // Guardar los detalles de la compra
            foreach ($request->detalles as $detalle) {
                $subtotal = ($detalle['precio_unitario_com'] * $detalle['cantidad_pro_detcom']) * (1 + ($detalle['iva_detcom'] / 100));
                $totalCompra += $subtotal;

                $compra->detalles()->create([
                    'codigo_pro' => $detalle['codigo_pro'],
                    'cantidad_pro_detcom' => $detalle['cantidad_pro_detcom'],
                    'precio_unitario_com' => $detalle['precio_unitario_com'],
                    'iva_detcom' => $detalle['iva_detcom'],
                    'subtotal_detcom' => $subtotal,
                ]);

                // Crear un lote
                Lote::create([
                    'codigo_pro' => $detalle['codigo_pro'],
                    'id_compra_lote' => $compra->id_com,
                    'fecha_compra' => $compra->fecha_emision_com,
                    'cantidad_lote' => $detalle['cantidad_pro_detcom'],
                    'cantidad_disponible' => $detalle['cantidad_pro_detcom'],
                    'peso_disponible_libras' => $detalle['peso_libras_pro'] ?? null,
                ]);

                // Registrar el movimiento en el kardex
                Kardex::create([
                    'codigo_pro' => $detalle['codigo_pro'],
                    'fecha_registro_kar' => now(),
                    'tipo_movimiento' => 'ENTRADA',
                    'cantidad_movimiento' => $detalle['cantidad_pro_detcom'],
                    'descripcion_movimiento' => 'Compra registrada',
                ]);

                // Actualizar el stock del producto
                $producto = Producto::find($detalle['codigo_pro']);
                $producto->stock_pro += $detalle['cantidad_pro_detcom'];
                $producto->save();
            }

            // Actualizar el total de la compra
            $compra->update(['total_com' => $totalCompra]);

            DB::commit();

            return redirect()->route('compras.index')->with('success', 'Compra registrada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Error al registrar la compra: ' . $e->getMessage()]);
        }
    }


    public function edit($id_com)
    {
        $compra = Compra::with('detalles')->findOrFail($id_com);
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        return view('compras.edit', compact('compra', 'proveedores', 'productos'));
    }

    public function update(Request $request, $id_com)
    {
        $request->validate([
            'compra.ruc_pro' => 'required|string|max:13|exists:proveedores,ruc_pro',
            'compra.fecha_emision_com' => 'required|date',
            'detalles' => 'required|array|min:1',
            'detalles.*.codigo_pro' => 'required|string|max:15|exists:productos,codigo_pro',
            'detalles.*.cantidad_pro_detcom' => 'required|integer|min:1',
            'detalles.*.precio_unitario_com' => 'required|numeric|min:0',
            'detalles.*.iva_detcom' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Obtener la compra existente
            $compra = Compra::findOrFail($id_com);
            $compra->update([
                'ruc_pro' => $request->input('compra.ruc_pro'),
                'fecha_emision_com' => $request->input('compra.fecha_emision_com'),
            ]);

            $totalCompra = 0;

            foreach ($request->input('detalles') as $detalle) {
                $subtotal = ($detalle['precio_unitario_com'] * $detalle['cantidad_pro_detcom']) * (1 + ($detalle['iva_detcom'] / 100));
                $totalCompra += $subtotal;

                // ACTUALIZAR el detalle existente
                DetalleCompra::where('id_detcom', $detalle['id_detcom'])->update([
                    'cantidad_pro_detcom' => $detalle['cantidad_pro_detcom'],
                    'precio_unitario_com' => $detalle['precio_unitario_com'],
                    'iva_detcom' => $detalle['iva_detcom'],
                    'subtotal_detcom' => $subtotal,
                ]);

                // 🔹 Buscar el lote correspondiente a este detalle
                $lote = Lote::where('codigo_pro', $detalle['codigo_pro'])
                    ->where('id_compra_lote', $compra->id_com)
                    ->first();

                // 🔹 Verificar si el lote puede ser actualizado (cantidad_lote == cantidad_disponible)
                if ($lote && $lote->cantidad_lote == $lote->cantidad_disponible) {
                    $lote->update([
                        'cantidad_lote' => $detalle['cantidad_pro_detcom'],
                        'cantidad_disponible' => $detalle['cantidad_pro_detcom'],
                    ]);
                }
            }

            // Actualizar el total de la compra
            $compra->update(['total_com' => $totalCompra]);

            DB::commit();
            return redirect()->route('compras.index')->with('success', 'Compra y lotes actualizados correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Error al actualizar la compra y los lotes: ' . $e->getMessage()]);
        }
    }



    public function destroy($id_com)
    {
        DB::beginTransaction();

        try {
            // Eliminar los lotes relacionados a la compra
            Lote::where('id_compra_lote', $id_com)->delete();

            // Eliminar los detalles de la compra
            DetalleCompra::where('id_com', $id_com)->delete();

            // Eliminar la compra
            Compra::where('id_com', $id_com)->delete();

            DB::commit();
            return redirect()->route('compras.index')->with('success', 'Compra y lotes eliminados exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Error al eliminar la compra: ' . $e->getMessage()]);
        }
    }
}
