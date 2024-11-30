<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener todos los clientes ordenados por 'id_cliente' en orden descendente, con paginación
        $clientes = Cliente::orderBy('id_cliente', 'DESC')->paginate(3);
        return view('cliente.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cliente.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validación de los campos del formulario antes de almacenar el cliente
        $request->validate([
             // Validar que 'id_cliente' sea único
            'nombre' => 'required',
            'email' => 'required|email|unique:clientes,email',   // Validar que 'email' sea único y formato válido
            'telefono' => 'nullable',  // El teléfono es opcional
            'direccion' => 'nullable', // La dirección también es opcional
        ]);

        // Crear un nuevo cliente en la base de datos usando el modelo Cliente
        Cliente::create($request->all());

        // Redirigir a la lista de clientes con un mensaje de éxito
        return redirect()->route('cliente.index')->with('success', 'Cliente creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id_cliente
     * @return \Illuminate\Http\Response
     */
    public function show($id_cliente)
    {
        // Obtener el cliente por su ID
        $cliente = Cliente::find($id_cliente);

        // Retornar la vista con los detalles del cliente
        return view('cliente.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id_cliente
     * @return \Illuminate\Http\Response
     */
    public function edit($id_cliente)
    {
        // Obtener el cliente para editarlo
        $cliente = Cliente::find($id_cliente);

        // Retornar la vista del formulario de edición con los datos del cliente
        return view('cliente.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id_cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_cliente)
    {
        $request->validate([
            'id_cliente'=> 'required|string|max:20',
            'nombre' => 'required|string|max:100',
            'direccion' => 'nullable|string|max:255',  // La dirección puede ser nula
            'telefono' => 'nullable|string|max:15',  // El teléfono puede ser nulo
            'email' => 'nullable|email|max:100|unique:clientes,email,' . $id_cliente . ',id_cliente',  // Email único pero permitido el mismo valor en la actualización
        ]);
        // Buscar el cliente por id_cliente
        $cliente = Cliente::find($id_cliente);

        // Si no se encuentra el cliente, redirigir con mensaje de error
        if (!$cliente) {
            return redirect()->route('cliente.index')->with('error', 'Cliente no encontrado');
        }

        //dd($id_cliente); 
        // Validación de los campos antes de actualizar el cliente
       

        

        // Actualizar los valores del cliente
        $cliente->nombre = $request->input('nombre');
        $cliente->direccion = $request->input('direccion');
        $cliente->telefono = $request->input('telefono');
        $cliente->email = $request->input('email');
        $cliente->fecha_registro = $cliente->fecha_registro;  // El campo fecha_registro no se actualiza
        // El campo created_at y updated_at son manejados automáticamente por Eloquent

        // Guardar los cambios
        $cliente->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('cliente.index')->with('success', 'Cliente actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id_cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_cliente)
    {
        // Encontrar el cliente por su id_cliente y eliminarlo
        Cliente::find($id_cliente)->delete();

        // Redirigir a la lista de clientes con un mensaje de éxito
        return redirect()->route('cliente.index')->with('success', 'Cliente eliminado satisfactoriamente');
    }
}
