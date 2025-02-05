<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Kardex;
use App\Models\Lote;
use App\Models\ConfiguracionDatos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;




class VentaController extends Controller
{
    public function index(Request $request)
    {
        // Obtiene el término de búsqueda si existe
        $search = $request->query('search');

        // Consulta de ventas con filtro si hay búsqueda
        $ventas = Venta::when($search, function ($query) use ($search) {
            return $query->where('id_ven', 'ILIKE', "%{$search}%")
                         ->orWhere('nombre_cli_ven', 'ILIKE', "%{$search}%");
        })->orderBy('fecha_emision_ven', 'desc')->paginate(10);

        return view('ventas.index', compact('ventas'));
    }

    public function generarPDF($id)
    {
        $venta = Venta::with('detalles.producto', 'cliente')->findOrFail($id);

        $pdf = Pdf::loadView('ventas.comprobante', compact('venta'));

        return $pdf->stream("Comprobante_Venta_{$venta->id_ven}.pdf");
    }

    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        $configuracion = ConfiguracionDatos::first();

        if (!$configuracion) {
            return redirect()->back()->withErrors(['error' => 'No hay datos de configuración registrados.']);
        }

        // Obtener la última venta registrada para determinar el número de factura
        $ultimaVenta = Venta::orderBy('numero_factura', 'desc')->first();
        $numeroFactura = $ultimaVenta ? str_pad($ultimaVenta->numero_factura + 1, 9, '0', STR_PAD_LEFT) : '000000001';

        // Generar un código numérico aleatorio de 8 dígitos
        $codigoAleatorio = str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);

        return view('ventas.create', compact('clientes', 'productos', 'configuracion', 'numeroFactura', 'codigoAleatorio'));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'venta.id_ven' => 'required|string|max:49|unique:ventas,id_ven',
            'venta.cedula_cli' => 'required|string|exists:clientes,cedula_cli',
            'venta.fecha_emision_ven' => 'required|date',
            'venta.numero_factura' => 'required|integer|unique:ventas,numero_factura',
            'detalles.*.codigo_pro' => 'required|string|exists:productos,codigo_pro',
            'detalles.*.cantidad_pro_detven' => 'required|integer|min:1',
            'detalles.*.precio_unitario_detven' => 'required|numeric|min:0',
            'detalles.*.iva_detven' => 'required|numeric|min:0|max:100',
            'detalles.*.tipo_venta' => 'required|string|in:UNIDAD,LIBRAS',
        ]);

        DB::beginTransaction();
        try {
            $cliente = Cliente::where('cedula_cli', $validated['venta']['cedula_cli'])->first();
            $numeroFactura = intval($validated['venta']['numero_factura']);

            $venta = Venta::create([
                'id_ven' => $validated['venta']['id_ven'],
                'cedula_cli' => $validated['venta']['cedula_cli'],
                'nombre_cli_ven' => $cliente->nombre_cli,
                'fecha_emision_ven' => $validated['venta']['fecha_emision_ven'],
                'numero_factura' => $numeroFactura,
                'total_ven' => 0,
            ]);

            $totalVenta = 0;

            foreach ($request->detalles as $detalle) {
                $codigoProducto = $detalle['codigo_pro'];
                $cantidadSolicitada = $detalle['cantidad_pro_detven'];

                // 🔹 Obtener los lotes disponibles ordenados por fecha más antigua (FIFO)
                $lotes = Lote::where('codigo_pro', $codigoProducto)
                    ->where('cantidad_disponible', '>', 0)
                    ->orderBy('fecha_compra', 'asc')
                    ->get();

                $cantidadRestante = $cantidadSolicitada;

                if ($lotes->sum('cantidad_disponible') < $cantidadSolicitada) {
                    return redirect()->back()->withErrors(['error' => "No hay suficiente stock para el producto $codigoProducto"]);
                }

                while ($cantidadRestante > 0 && $lotes->isNotEmpty()) {
                    $lote = $lotes->shift(); // Obtiene el lote más antiguo
                    $cantidadADescontar = min($cantidadRestante, $lote->cantidad_disponible);

                    // 🔹 Registrar la venta en detalles_ventas
                    $subtotal = ($detalle['precio_unitario_detven'] * $cantidadADescontar) +
                        ($detalle['precio_unitario_detven'] * $cantidadADescontar * ($detalle['iva_detven'] / 100));
                    $totalVenta += $subtotal;

                    $venta->detalles()->create([
                        'codigo_pro' => $codigoProducto,
                        'cantidad_pro_detven' => $cantidadADescontar,
                        'precio_unitario_detven' => $detalle['precio_unitario_detven'],
                        'iva_detven' => $detalle['iva_detven'],
                        'subtotal_detven' => $subtotal,
                        'tipo_venta' => $detalle['tipo_venta'],
                    ]);

                    // 🔹 Actualizar el lote
                    $lote->cantidad_disponible -= $cantidadADescontar;
                    $lote->save();

                    // 🔹 Registrar en el Kardex
                    Kardex::create([
                        'codigo_pro' => $codigoProducto,
                        'fecha_registro_kar' => now(),
                        'tipo_movimiento' => 'SALIDA',
                        'cantidad_movimiento' => $cantidadADescontar,
                        'descripcion_movimiento' => 'Venta realizada',
                    ]);

                    $cantidadRestante -= $cantidadADescontar;
                }
            }

            // 🔹 Actualizar el total de la venta
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
            'detalles.*.precio_unitario_detven' => 'required|numeric|min:0', // ✅ Validación del precio unitario
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
                $subtotal = ($detalle['precio_unitario_detven'] * $detalle['cantidad_pro_detven']) +
                    ($detalle['precio_unitario_detven'] * $detalle['cantidad_pro_detven'] * ($detalle['iva_detven'] / 100));
                $totalVenta += $subtotal;

                $venta->detalles()->create([
                    'codigo_pro' => $detalle['codigo_pro'],
                    'cantidad_pro_detven' => $detalle['cantidad_pro_detven'],
                    'precio_unitario_detven' => $detalle['precio_unitario_detven'], // ✅ Se guarda en la actualización
                    'iva_detven' => $detalle['iva_detven'],
                    'subtotal_detven' => $subtotal,
                    'tipo_venta' => $detalle['tipo_venta'],
                ]);
            }

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
