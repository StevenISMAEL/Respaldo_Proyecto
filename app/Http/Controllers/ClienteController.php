<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;

class ClienteController extends Controller
{
    /**
     * Mostrar lista de clientes con búsqueda.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $clientes = Cliente::when($search, function ($query) use ($search) {
            return $query->whereRaw("LOWER(cedula_cli) ILIKE ?", ["%".strtolower($search)."%"])
                         ->orWhereRaw("LOWER(nombre_cli) ILIKE ?", ["%".strtolower($search)."%"]);
        })->paginate(10);

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
     * Almacenar un nuevo cliente en la base de datos con validaciones de cédula y teléfono.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cedula_cli'    => 'required|unique:clientes,cedula_cli|max:10',
            'nombre_cli'    => 'required|string|max:100',
            'direccion_cli' => 'nullable|string|max:150',
            'telefono_cli'  => 'nullable|string|max:10',
            'correo_cli'    => 'nullable|email|max:100',
        ]);

        // **Validar cédula con la función de PostgreSQL**
        $esCedulaValida = DB::select('SELECT validar_cedula_ecuatoriana(?) AS valido', [$request->cedula_cli]);

        if (!$esCedulaValida[0]->valido) {
            return redirect()->back()->withErrors(['cedula_cli' => 'La cédula ingresada no es válida.'])->withInput();
        }

        // **Validar teléfono con la función de PostgreSQL**
        $esTelefonoValido = DB::select("SELECT validar_telefono_ecuadoriano(?) AS valido", [$request->telefono_cli]);

        if (!$esTelefonoValido[0]->valido) {
            return redirect()->back()->withErrors(['telefono_cli' => 'El teléfono debe tener exactamente 10 dígitos.'])->withInput();
        }

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
     * Actualizar la información de un cliente con validaciones de cédula y teléfono.
     */
    public function update(Request $request, $cedula_cli)
    {
        $request->validate([
            'nombre_cli'    => 'required|string|max:100',
            'direccion_cli' => 'nullable|string|max:150',
            'telefono_cli'  => 'nullable|string|max:10',
            'correo_cli'    => 'nullable|email|max:100',
        ]);

        // **Validar cédula con la función de PostgreSQL**
        $esCedulaValida = DB::select('SELECT validar_cedula_ecuatoriana(?) AS valido', [$cedula_cli]);

        if (!$esCedulaValida[0]->valido) {
            return redirect()->back()->withErrors(['cedula_cli' => 'La cédula ingresada no es válida.'])->withInput();
        }

        // **Validar teléfono con la función de PostgreSQL**
        $esTelefonoValido = DB::select("SELECT validar_telefono_ecuadoriano(?) AS valido", [$request->telefono_cli]);

        if (!$esTelefonoValido[0]->valido) {
            return redirect()->back()->withErrors(['telefono_cli' => 'El teléfono debe tener exactamente 10 dígitos.'])->withInput();
        }

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
