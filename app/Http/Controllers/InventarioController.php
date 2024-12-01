<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    /**
     * Mostrar una lista de todos los inventarios.
     */
    public function index()
    {
        $inventarios = Inventario::orderBy('fecha_registro', 'desc')->paginate(5);
        return view('inventario.index', compact('inventarios'));
    }

    /**
     * Mostrar el formulario para crear un nuevo inventario.
     */
    public function create()
    {
        return view('inventario.create');
    }

    /**
     * Almacenar un nuevo inventario en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:20|unique:inventario', 
            'nombre_producto' => 'nullable|string|max:40',
            'cantidad_disponible' => 'required|numeric',
        ]);

        Inventario::create([
            'codigo' => $request->input('codigo'),
            'nombre_producto' => $request->input('nombre_producto'),
            'cantidad_disponible' => $request->input('cantidad_disponible'),
        ]);

        return redirect()->route('inventario.index')->with('success', 'Producto agregado correctamente');
    }

    /**
     * Mostrar el inventario especificado.
     */
    public function show($codigo)
    {
        $inventario = Inventario::findOrFail($codigo);
        return view('inventario.show', compact('inventario'));
    }

    /**
     * Mostrar el formulario para editar el inventario especificado.
     */
    public function edit($codigo)
    {
        $inventario = Inventario::findOrFail($codigo);
        return view('inventario.edit', compact('inventario'));
    }

    /**
     * Actualizar un inventario existente en la base de datos.
     */
    public function update(Request $request, $codigo)
    {
        $request->validate([
            'codigo' => 'required|string|max:20',
            'nombre_producto' => 'nullable|string|max:40',
            'cantidad_disponible' => 'required|numeric',
        ]);

        $inventario = Inventario::findOrFail($codigo);
        $inventario->update($request->all());

        return redirect()->route('inventario.index')->with('success', 'Producto actualizado correctamente');
    }

    /**
     * Eliminar un inventario especificado de la base de datos.
     */
    public function destroy($codigo)
    {
        $inventario = Inventario::findOrFail($codigo);
        $inventario->delete();

        return redirect()->route('inventario.index')->with('success', 'Producto eliminado correctamente');
    }
}
