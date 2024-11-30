@extends('plantilla.plantilla')

@section('content')
    <div class="row">
        <section class="content">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="pull-left">
                            <h3>Lista de Productos - Arellano Leonel</h3>
                        </div>
                        <div class="pull-right">
                            <div class="btn-group">
                                <a href="{{ route('producto.create') }}" class="btn btn-info">Añadir Producto</a>
                            </div>
                        </div>
                        <div class="table-container">
                            <table id="mytable" class="table table-bordred table-striped">
                                <thead>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Tipo de Producto</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                    <th>Alimenticio</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </thead>
                                <tbody>
                                    @if ($productos->count())
                                        @foreach ($productos as $producto)
                                            <tr>
                                                <td>{{ $producto->codigo }}</td>
                                                <td>{{ $producto->nombre }}</td>
                                                <td>{{ $producto->tipo_producto }}</td>
                                                <td>{{ $producto->precio_unitario }}</td>
                                                <td>{{ $producto->estado }}</td>
                                                <td>{{ $producto->alimenticio ? 'Sí' : 'No' }}</td>
                                                <td><a class="btn btn-primary btn-xs"
                                                        href="{{ route('producto.edit', $producto->codigo) }}"><span
                                                            class="glyphicon glyphicon-pencil"></span></a></td>
                                                <td>
                                                    <form action="{{ route('producto.destroy', $producto->codigo) }}"
                                                        method="post">
                                                        {{ csrf_field() }}
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button class="btn btn-danger btn-xs" type="submit"><span
                                                                class="glyphicon glyphicon-trash"></span></button>
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
                        </div>
                    </div>
                    {{ $productos->links() }} <!-- Paginación -->
                </div>
            </div>
        </section>
    @endsection
