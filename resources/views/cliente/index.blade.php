@extends('plantilla.plantilla')
@section('content')
    <div class="row">
        <section class="content">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="pull-left">
                            <h3>Lista de Clientes - Arellano Leonel</h3>
                        </div>
                        <div class="pull-right">
                            <div class="btn-group">
                                <a href="{{ route('cliente.create') }}" class="btn btn-info">Añadir Cliente</a>
                            </div>
                        </div>
                        <div class="table-container">
                            <table id="mytable" class="table table-bordred table-striped">
                                <thead>
                                    <th>ID Cliente</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </thead>
                                <tbody>
                                    @if ($clientes->count())
                                        @foreach ($clientes as $cliente)
                                            <tr>
                                                <td>{{ $cliente->id_cliente }}</td>
                                                <td>{{ $cliente->nombre }}</td>
                                                <td>{{ $cliente->email }}</td>
                                                <td>{{ $cliente->telefono }}</td>
                                                <td>{{ $cliente->direccion }}</td>
                                                <td><a class="btn btn-primary btn-xs"
                                                        href="{{ route('cliente.edit', $cliente->id_cliente) }}"><span
                                                            class="glyphicon glyphicon-pencil"></span></a></td>
                                                <td>
                                                    <form action="{{ route('cliente.destroy', $cliente->id_cliente) }}"
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
                                            <td colspan="7">No hay registros disponibles.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $clientes->links() }} <!-- Paginación -->
                </div>
            </div>
        </section>
    @endsection
