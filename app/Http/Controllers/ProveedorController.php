<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener todos los proveedores, ordenados por nombre descendente
        $proveedores = Proveedor::orderBy('nombre_pro', 'DESC')->paginate(3);
        return view('proveedor.index', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('proveedor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'ruc_pro' => 'required|string|size:13|unique:proveedores,ruc_pro',
            'nombre_pro' => 'required|string|max:50',
            'correo_pro' => 'nullable|email|max:100',
            'telefono_pro' => 'nullable|string|max:10',
            'direccion_pro' => 'nullable|string|max:150',
            'activo_pro' => 'required|boolean',
            'notas_pro' => 'nullable|string|max:500',
        ]);

        // Crear el proveedor con los datos validados
        Proveedor::create($request->all());

        // Redirigir con mensaje de éxito
        return redirect()->route('proveedor.index')->with('success', 'Proveedor creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $ruc_pro
     * @return \Illuminate\Http\Response
     */
    public function show($ruc_pro)
    {
        // Obtener el proveedor por su RUC
        $proveedor = Proveedor::findOrFail($ruc_pro);
        return view('proveedor.show', compact('proveedor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $ruc_pro
     * @return \Illuminate\Http\Response
     */
    public function edit($ruc_pro)
    {
        $proveedor = Proveedor::findOrFail($ruc_pro);
        return view('proveedor.edit', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $ruc_pro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ruc_pro)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombre_pro' => 'required|string|max:50',
            'correo_pro' => 'nullable|email|max:100',
            'telefono_pro' => 'nullable|string|max:10',
            'direccion_pro' => 'nullable|string|max:150',
            'activo_pro' => 'required|boolean',
            'notas_pro' => 'nullable|string|max:500',
        ]);

        // Buscar el proveedor por su RUC
        $proveedor = Proveedor::findOrFail($ruc_pro);

        // Actualizar los campos del proveedor con los datos del formulario
        $proveedor->update($request->all());

        // Redirigir con mensaje de éxito
        return redirect()->route('proveedor.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $ruc_pro
     * @return \Illuminate\Http\Response
     */
    public function destroy($ruc_pro)
    {
        // Eliminar el proveedor por su RUC
        Proveedor::findOrFail($ruc_pro)->delete();

        return redirect()->route('proveedor.index')->with('success', 'Proveedor eliminado satisfactoriamente');
    }
}
