@extends('plantilla.plantilla')

@section('content')
    <div class="row">
        <section class="content">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="pull-left">
                            <h3>Lista Inventario de Productos Lara S</h3>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('inventario.create') }}" class="btn btn-info">Añadir Producto al Inventario</a>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Fecha Registro</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($inventarios->count())
                                    @foreach ($inventarios as $inventario)
                                        <tr>
                                            <td>{{ $inventario->codigo }}</td>
                                            <td>{{ $inventario->nombre_producto }}</td>
                                            <td>{{ $inventario->cantidad_disponible }}</td>
                                            <td>{{ $inventario->fecha_registro }}</td>
                                            <td>
                                                <a href="{{ route('inventario.edit', $inventario->codigo) }}"
                                                    class="btn btn-primary btn-xs">Editar</a>
                                                <form action="{{ route('inventario.destroy', $inventario->codigo) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-xs">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8">No hay registros disponibles.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        {{ $inventarios->links() }}
                    </div>
                </div>
            </div>
        </section>
    @endsection
