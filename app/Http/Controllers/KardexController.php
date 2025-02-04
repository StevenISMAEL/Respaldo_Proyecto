<?php

namespace App\Http\Controllers;

use App\Models\Kardex;
use App\Models\Producto;
use Illuminate\Http\Request;

class KardexController extends Controller
{
    /**
     * Mostrar un listado de los movimientos de inventario.
     */
    public function index()
    {
        $kardex = Kardex::with('producto')->paginate(10);
        return view('kardex.index', compact('kardex'));
    }

    /**
     * Mostrar el formulario para crear un nuevo registro en el kardex.
     */
    public function create()
    {
        $productos = Producto::all();
        return view('kardex.create', compact('productos'));
    }

    /**
     * Guardar un nuevo registro de movimiento en el kardex.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo_pro' => 'required|exists:productos,codigo_pro',
            'tipo_movimiento' => 'required|string|in:ENTRADA,SALIDA,AJUSTE',
            'cantidad_movimiento' => 'required|integer|min:1',
            'descripcion_movimiento' => 'nullable|string|max:100',
        ]);

        Kardex::create([
            'codigo_pro' => $request->codigo_pro,
            'tipo_movimiento' => $request->tipo_movimiento,
            'cantidad_movimiento' => $request->cantidad_movimiento,
            'descripcion_movimiento' => $request->descripcion_movimiento,
            'fecha_registro_kar' => now(), // Se usa la fecha actual automáticamente
        ]);

        return redirect()->route('kardex.index')->with('success', 'Movimiento registrado correctamente.');
    }

    /**
     * Mostrar los detalles de un registro específico.
     */
    public function show($id)
    {
        $kardex = Kardex::with('producto')->findOrFail($id);
        return view('kardex.show', compact('kardex'));
    }

    /**
     * Mostrar el formulario de edición de un registro.
     */
    public function edit($id)
    {
        $kardex = Kardex::findOrFail($id);
        $productos = Producto::all();
        return view('kardex.edit', compact('kardex', 'productos'));
    }

    /**
     * Actualizar un registro de movimiento en el kardex.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo_pro' => 'required|exists:productos,codigo_pro',
            'tipo_movimiento' => 'required|string|in:ENTRADA,SALIDA,AJUSTE',
            'cantidad_movimiento' => 'required|integer|min:1',
            'descripcion_movimiento' => 'nullable|string|max:100',
        ]);

        $kardex = Kardex::findOrFail($id);
        $kardex->update([
            'codigo_pro' => $request->codigo_pro,
            'tipo_movimiento' => $request->tipo_movimiento,
            'cantidad_movimiento' => $request->cantidad_movimiento,
            'descripcion_movimiento' => $request->descripcion_movimiento,
        ]);

        return redirect()->route('kardex.index')->with('success', 'Movimiento actualizado correctamente.');
    }

    /**
     * Eliminar un registro del kardex.
     */
    public function destroy($id)
    {
        $kardex = Kardex::findOrFail($id);
        $kardex->delete();

        return redirect()->route('kardex.index')->with('success', 'Movimiento eliminado correctamente.');
    }
}
