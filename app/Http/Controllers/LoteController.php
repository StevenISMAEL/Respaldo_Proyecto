<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lote;
use App\Models\Producto;

class LoteController extends Controller
{
    /**
     * Mostrar lista de lotes.
     */
    public function index()
    {
        $lotes = Lote::with('producto')->orderBy('fecha_compra', 'desc')->paginate(10);
        return view('lotes.index', compact('lotes'));
    }

    /**
     * Mostrar formulario para crear un nuevo lote.
     */
    public function create()
    {
        $productos = Producto::all(); // Obtener todos los productos para el formulario
        return view('lotes.create', compact('productos'));
    }

    /**
     * Almacenar un nuevo lote en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo_pro'            => 'required|exists:productos,codigo_pro',
            'id_compra_lote'        => 'nullable|string|max:15', // Permitir guardar el ID de la compra
            'fecha_compra'          => 'required|date',
            'cantidad_lote'         => 'required|integer|min:1',
            'cantidad_disponible'   => 'required|integer|min:0',
            'peso_disponible_libras' => 'nullable|numeric|min:0',
        ]);
        Lote::create([
            'codigo_pro'            => $request->codigo_pro,
            'id_compra_lote'        => $request->id_compra_lote, // Guardar el ID de la compra si está presente
            'fecha_compra'          => $request->fecha_compra,
            'cantidad_lote'         => $request->cantidad_lote,
            'cantidad_disponible'   => $request->cantidad_disponible,
            'peso_disponible_libras' => $request->peso_disponible_libras,
        ]);
       

        return redirect()->route('lotes.index')->with('success', 'Lote creado exitosamente.');
    }

    /**
     * Mostrar detalles de un lote específico.
     */
    public function show($id)
    {
        $lote = Lote::with('producto')->findOrFail($id);
        return view('lotes.show', compact('lote'));
    }

    /**
     * Mostrar formulario para editar un lote.
     */
    public function edit($id)
    {
        $lote = Lote::findOrFail($id);
        $productos = Producto::all();
        return view('lotes.edit', compact('lote', 'productos'));
    }

    /**
     * Actualizar la información de un lote.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo_pro'            => 'required|exists:productos,codigo_pro',
            'id_compra_lote'        => 'nullable|string|max:15', // Permitir actualizar el ID de la compra
            'fecha_compra'          => 'required|date',
            'cantidad_lote'         => 'required|integer|min:1',
            'cantidad_disponible'   => 'required|integer|min:0',
            'peso_disponible_libras' => 'nullable|numeric|min:0',
        ]);

        $lote = Lote::findOrFail($id);
        $lote->update([
            'codigo_pro'            => $request->codigo_pro,
            'id_compra_lote'        => $request->id_compra_lote, // Asegurar que se pueda actualizar el campo
            'fecha_compra'          => $request->fecha_compra,
            'cantidad_lote'         => $request->cantidad_lote,
            'cantidad_disponible'   => $request->cantidad_disponible,
            'peso_disponible_libras' => $request->peso_disponible_libras,
        ]);

        return redirect()->route('lotes.index')->with('success', 'Lote actualizado exitosamente.');
    }

    /**
     * Eliminar un lote de la base de datos.
     */
    public function destroy($id)
    {
        $lote = Lote::findOrFail($id);
        $lote->delete();

        return redirect()->route('lotes.index')->with('success', 'Lote eliminado exitosamente.');
    }
}
