<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Mostrar una lista de productos.
     *
     * @return \Illuminate\View\Response
     */
    public function index()
    {
        // Obtener todos los productos, puedes aplicar paginación si lo deseas
        $productos = Producto::orderBy('codigo', 'DESC')->paginate(3);
        return view('producto.index', compact('productos'));
    }

    /**
     * Mostrar el formulario para crear un nuevo producto.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('producto.create');
    }

    /**
     * Almacenar un nuevo producto en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'codigo' => 'required|string|max:20|unique:productos,codigo',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'tipo_producto' => 'required|string|max:50',
            'precio_unitario' => 'required|numeric|min:0',
            'estado' => 'nullable|string|max:20',
            'alimenticio' => 'required|boolean',
        ]);

        // Crear el nuevo producto
        Producto::create($request->all());

        // Redirigir al listado de productos con mensaje de éxito
        return redirect()->route('producto.index')->with('success', 'Producto creado con éxito.');
    }

    /**
     * Mostrar el formulario para editar un producto existente.
     *
     * @param  string  $codigo
     * @return \Illuminate\View\View
     */
    public function edit($codigo)
    {
        // Buscar el producto por su código
        $producto = Producto::findOrFail($codigo);
        return view('producto.edit', compact('producto'));
    }

    /**
     * Actualizar un producto existente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $codigo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $codigo)
    {
        // Validar los datos de entrada
        $request->validate([
            'codigo' => 'required|string|max:20|unique:productos,codigo,' . $codigo . ',codigo',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'tipo_producto' => 'required|string|max:50',
            'precio_unitario' => 'required|numeric|min:0',
            'estado' => 'nullable|string|max:20',
            'alimenticio' => 'required|boolean',
        ]);

        // Buscar el producto por su código
        $producto = Producto::findOrFail($codigo);

        // Actualizar los datos del producto
        $producto->update($request->all());

        // Redirigir al listado de productos con mensaje de éxito
        return redirect()->route('producto.index')->with('success', 'Producto actualizado con éxito.');
    }

    /**
     * Eliminar un producto de la base de datos.
     *
     * @param  string  $codigo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($codigo)
    {
        // Buscar el producto por su código
        $producto = Producto::findOrFail($codigo);

        // Eliminar el producto
        $producto->delete();

        // Redirigir al listado de productos con mensaje de éxito
        return redirect()->route('producto.index')->with('success', 'Producto eliminado con éxito.');
    }
}
