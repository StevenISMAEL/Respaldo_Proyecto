<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    /**
     * Mostrar lista de clientes.
     */
    public function index()
    {
        $clientes = Cliente::orderBy('created_at', 'desc')->paginate(10); // Ordenar por fecha de creación
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Mostrar formulario para crear un nuevo cliente.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Almacenar un nuevo cliente en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cedula_cli'        => 'required|unique:clientes,cedula_cli|max:10',
            'nombre_cli'        => 'required|string|max:100',
            'direccion_cli'     => 'nullable|string|max:150',
            'telefono_cli'      => 'nullable|string|max:10',
            'correo_cli'        => 'nullable|email|max:100',
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente creado con éxito.');
    }

    /**
     * Mostrar detalles de un cliente.
     */
    public function show($cedula_cli)
    {
        $cliente = Cliente::findOrFail($cedula_cli);
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Mostrar formulario para editar un cliente.
     */
    public function edit($cedula_cli)
    {
        $cliente = Cliente::findOrFail($cedula_cli);
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Actualizar la información de un cliente.
     */
    public function update(Request $request, $cedula_cli)
    {
        $request->validate([
            'nombre_cli'        => 'required|string|max:100',
            'direccion_cli'     => 'nullable|string|max:150',
            'telefono_cli'      => 'nullable|string|max:10',
            'correo_cli'        => 'nullable|email|max:100',
        ]);

        $cliente = Cliente::findOrFail($cedula_cli);
        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado con éxito.');
    }

    /**
     * Eliminar un cliente de la base de datos.
     */
    public function destroy($cedula_cli)
    {
        $cliente = Cliente::findOrFail($cedula_cli);
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado con éxito.');
    }
}
