<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bulto; 


class BultoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bultos = Bulto::orderBy('codigo', 'DESC')->paginate(10); // Usamos paginación

        return view('bulto.index', compact('bultos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bulto.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // Validar los datos de entrada
    $request->validate([
        'tipo_animal' => 'required|string',
        'tamano_raza' => 'required|string',
        'peso_lb' => 'required|numeric',
        'precio_por_libra' => 'required|numeric',
        'stock_minimo_bultos' => 'required|integer',
    ]);

    $lastBulto = Bulto::latest()->first(); 
    $lastCode = $lastBulto ? (int)substr($lastBulto->codigo, 5) : 0; 
    $newCode = 'bulto' . str_pad($lastCode + 1, 3, '0', STR_PAD_LEFT); 

    while (Bulto::where('codigo', $newCode)->exists()) {
        $newCode = 'bulto' . str_pad($lastCode + 1, 3, '0', STR_PAD_LEFT); 
        $lastCode++;
    }

    $bulto = new Bulto();
    $bulto->codigo = $newCode;
    $bulto->tipo_animal = $request->tipo_animal;
    $bulto->tamano_raza = $request->tamano_raza;
    $bulto->peso_lb = $request->peso_lb;
    $bulto->precio_por_libra = $request->precio_por_libra;
    $bulto->stock_minimo_bultos = $request->stock_minimo_bultos;
    $bulto->save();

    return redirect()->route('bulto.index')->with('success', 'Bulto registrado exitosamente.');
}

    

    /**
     * Display the specified resource.
     *
     * @param  int  $codigo
     * @return \Illuminate\Http\Response
     */
    public function show($codigo)
    {
        $bulto = Bulto::findOrFail($codigo);

        return view('bulto.show', compact('bulto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $codigo
     * @return \Illuminate\Http\Response
     */
    public function edit($codigo)
    {
        $bulto = Bulto::findOrFail($codigo);
    
        return view('bulto.edit', compact('bulto'));
    }
    


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $codigo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $codigo)
    {
        $bulto = Bulto::findOrFail($codigo);

        $request->validate([
            'tipo_animal' => 'required|string|max:50',
            'tamano_raza' => 'nullable|string|max:50',
            'peso_lb' => 'required|numeric',
            'precio_por_libra' => 'required|numeric',
            'stock_minimo_bultos' => 'required|integer',
        ]);

        $bulto->update($request->all());

        return redirect()->route('bulto.index')->with('success', 'Bulto actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $codigo
     * @return \Illuminate\Http\Response
     */
    public function destroy($codigo)
    {
        $bulto = Bulto::findOrFail($codigo);
        $bulto->delete();

        return redirect()->route('bulto.index')->with('success', 'Bulto eliminado satisfactoriamente');
    }
}
