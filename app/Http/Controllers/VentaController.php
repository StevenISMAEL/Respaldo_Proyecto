<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;


class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Mostrar todas las ventas con paginación
        $ventas = Venta::orderBy('fecha_venta', 'desc')->paginate(10);
        return view('venta.index', compact('ventas'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'total' => 'required|numeric',
            'estado_venta' => 'required|in:Pendiente,Pagado,Cancelado',
            'metodo_pago' => 'required|string|max:50',
        ]);

        $venta = new Venta();
        $venta->total = $request->total;
        $venta->estado_venta = $request->estado_venta;
        $venta->metodo_pago = $request->metodo_pago;
        $venta->save();

        $venta->codigo = 'venta' . str_pad($venta->id, 3, '0', STR_PAD_LEFT); // 'venta001', 'venta002', etc.


        return redirect()->route('venta.index')->with('success', 'Venta registrada exitosamente.');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lastVenta = Venta::latest()->first();

        $nextCode = 'venta' . str_pad(($lastVenta ? (int)substr($lastVenta->codigo, 5) + 1 : 1), 3, '0', STR_PAD_LEFT);

        return view('venta.create', compact('nextCode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // Validar los datos de entrada


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $venta = Venta::findOrFail($id);
        return view('venta.show', compact('venta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
{
    $venta = Venta::findOrFail($id);

    return view('venta.edit', compact('venta'));
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validar los datos
        $request->validate([
            'total' => 'required|numeric',
            'estado_venta' => 'required|in:Pendiente,Pagado,Cancelado',
            'metodo_pago' => 'required|string|max:50',
        ]);

        // Buscar la venta y actualizarla
        $venta = Venta::findOrFail($id);
        $venta->update($request->all());

        return redirect()->route('venta.index')->with('success', 'Venta actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Buscar la venta y eliminarla
        $venta = Venta::findOrFail($id);
        $venta->delete();

        return redirect()->route('venta.index')->with('success', 'Venta eliminada exitosamente.');
    }
}
