@extends('plantilla.plantilla')

@section('content')
<div class="row">
    <section class="content">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Ventas</h3>
                </div>
                <div class="panel-body">
                    <a href="{{ route('venta.create') }}" class="btn btn-success">Nueva Venta</a>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Método de Pago</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ventas as $venta)
                            <tr>
                                <td>{{ 'venta' . str_pad($venta->id, 3, '0', STR_PAD_LEFT) }}</td> <!-- Mostrar el código generado -->
                                <td>{{ $venta->total }}</td>
                                <td>{{ $venta->estado_venta }}</td>
                                <td>{{ $venta->metodo_pago }}</td>
                                <td>
                                    <a href="{{ route('venta.edit', $venta->id) }}" class="btn btn-primary btn-sm">Editar</a>
                                    <form action="{{ route('venta.destroy', $venta->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $ventas->links() }} <!-- Paginación -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
