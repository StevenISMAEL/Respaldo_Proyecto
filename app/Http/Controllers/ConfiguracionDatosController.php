<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfiguracionDatos;

class ConfiguracionDatosController extends Controller
{
    // Mostrar configuración
    public function index()
    {
        $configuracion = ConfiguracionDatos::first(); // Solo debe haber un registro
        return view('configuracion_datos.index', compact('configuracion'));
    }
    public function create()
    {
        return view('configuracion_datos.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'ruc_emisor' => 'required|string|size:13|unique:configuracion_datos,ruc_emisor',
            'nombre_negocio' => 'required|string|max:100',
            'direccion_negocio' => 'nullable|string|max:200',
            'telefono_negocio' => 'nullable|string|max:15',
            'correo_negocio' => 'nullable|email|max:100',
            'codigo_establecimiento' => 'required|string|size:3|regex:/^\d{3}$/',
            'codigo_emision' => 'required|string|size:3|regex:/^\d{3}$/',
        ]);

        ConfiguracionDatos::create($request->all());

        return redirect()->route('configuracion_datos.index')->with('success', 'Configuración guardada correctamente.');
    }


    // Formulario para editar
    public function edit($id)
    {
        $configuracion = ConfiguracionDatos::findOrFail($id);
        return view('configuracion_datos.edit', compact('configuracion'));
    }

    // Actualizar datos
    public function update(Request $request, $id)
    {
        $request->validate([
            'ruc_emisor' => 'required|string|size:13|unique:configuracion_datos,ruc_emisor,' . $id,
            'nombre_negocio' => 'required|string|max:100',
            'direccion_negocio' => 'nullable|string|max:200',
            'telefono_negocio' => 'nullable|string|max:15',
            'correo_negocio' => 'nullable|email|max:100',
            'codigo_establecimiento' => 'required|string|size:3|regex:/^\d{3}$/',
            'codigo_emision' => 'required|string|size:3|regex:/^\d{3}$/',
        ]);

        $configuracion = ConfiguracionDatos::findOrFail($id);
        $configuracion->update($request->all());

        return redirect()->route('configuracion_datos.index')->with('success', 'Configuración actualizada correctamente.');
    }
}
