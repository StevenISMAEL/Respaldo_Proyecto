<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;

class ProductoController extends Controller
{
    /**
     * Mostrar una lista de productos con paginación.
     */
    public function index()
    {
        $productos = Producto::orderBy('created_at', 'desc')->paginate(10);
        return view('producto.index', compact('productos'));
    }

    /**
     * Mostrar el formulario para crear un nuevo producto.
     */
    public function create()
    {
        return view('producto.create');
    }

    /**
     * Almacenar un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos recibidos del formulario
        $request->validate([
            'codigo_pro'         => 'required|string|max:15|unique:productos,codigo_pro',
            'nombre_pro'         => 'required|string|max:50',
            'descripcion_pro'    => 'nullable|string|max:100',
            'precio_unitario_pro' => 'required|numeric|min:0',
            'precio_libras_pro'  => 'nullable|numeric|min:0',
            'alimenticio_pro'    => 'required|boolean',
            'tipo_animal_pro'    => 'required|string|max:50',
            'tamano_raza_pro'    => 'nullable|string|max:20',
            'peso_libras_pro'    => 'nullable|numeric|min:0',
            'minimo_pro'         => 'required|integer|min:0',
            'maximo_pro'         => 'required|integer|min:0',
        ]);

        Producto::create($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto creado satisfactoriamente.');
    }

    /**
     * Mostrar el formulario de edición de un producto.
     */
    public function edit($codigo)
    {
        $producto = Producto::findOrFail($codigo);
        return view('producto.edit', compact('producto'));
    }

    /**
     * Actualizar un producto en la base de datos.
     */
    public function update(Request $request, $codigo_pro)
    {
        $producto = Producto::findOrFail($codigo_pro);

        // Si el producto tiene lotes, no permitir edición de ciertos campos
        if ($producto->lotes()->count() > 0) {
            $request->merge([
                'producto' => array_merge($request->input('producto'), [
                    'alimenticio_pro' => $producto->alimenticio_pro,
                    'peso_libras_pro' => $producto->peso_libras_pro,
                    'precio_libras_pro' => $producto->precio_libras_pro
                ])
            ]);
        }

        // Validar los datos permitidos
        $request->validate([
            'producto.nombre_pro' => 'required|string|max:50',
            'producto.descripcion_pro' => 'nullable|string|max:100',
            'producto.precio_unitario_pro' => 'required|numeric|min:0',
            'producto.minimo_pro' => 'required|integer|min:0',
            'producto.maximo_pro' => 'required|integer|min:0',
            'producto.tipo_animal_pro' => 'required|string|max:50',
            'producto.tamano_raza_pro' => 'required|string|max:20',
        ]);

        $producto->update($request->input('producto'));

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }


    /**
     * Eliminar un producto de la base de datos.
     */
    public function destroy($codigo)
    {
        try {
            $producto = Producto::findOrFail($codigo);
            $producto->delete();

            return redirect()->route('producto.index')->with('success', 'Producto eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error al eliminar el producto: ' . $e->getMessage()]);
        }
    }
}
