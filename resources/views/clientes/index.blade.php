@extends('plantilla.plantilla')

@section('content')
<div class="container-fluid">
    <!-- Sección de métricas -->
    <div class="row">
        <div class="col-md-3">
            <div class="panel-card" style="background-color: #f0ad4e;">
                <h3><i class="glyphicon glyphicon-user"></i> Total Clientes</h3>
                <p style="font-size: 24px;">{{ $clientes->count() }}</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="panel-card" style="background-color: #5bc0de;">
                <h3><i class="glyphicon glyphicon-check"></i> Activos</h3>
                <p style="font-size: 24px;">{{ $clientes->where('activo', 1)->count() }}</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="panel-card" style="background-color: #5cb85c;">
                <h3><i class="glyphicon glyphicon-remove"></i> Inactivos</h3>
                <p style="font-size: 24px;">{{ $clientes->where('activo', 0)->count() }}</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="panel-card" style="background-color: #d9534f;">
                <h3><i class="glyphicon glyphicon-time"></i> Última Edición</h3>
                <p style="font-size: 24px;">
                    {{ $clientes->max('updated_at') ? \Carbon\Carbon::parse($clientes->max('updated_at'))->format('d-m-Y') : 'N/A' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Sección de clientes -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-left">
                        <h3><i class="glyphicon glyphicon-user"></i> Lista de Clientes</h3>
                    </div>
                    <div class="pull-right">
                        <a href="{{ route('clientes.create') }}" class="btn btn-success">
                            <i class="glyphicon glyphicon-plus"></i> Añadir Cliente
                        </a>
                    </div>
                    <div class="clearfix"></div>

                    <!-- Barra de búsqueda -->
                    <form action="{{ route('clientes.index') }}" method="GET" class="form-inline" style="margin-top: 10px;">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Buscar por código o nombre..." value="{{ request('search') }}">
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="submit">
                                    <i class="glyphicon glyphicon-search"></i> Buscar
                                </button>
                            </span>
                            @if(request()->has('search') && request('search') !== '')
                                <span style="margin-left: 8px;" class="input-group-btn">
                                    <a href="{{ route('clientes.index') }}" class="btn btn-danger">
                                        <i class="glyphicon glyphicon-remove"></i> Quitar Filtro
                                    </a>
                                </span>
                            @endif
                        </div>
                    </form>

                    <div class="table-container">
                        <table class="table table-bordered table-striped" style="margin-top: 15px;">
                            <thead>
                                <tr>
                                    <th>Cédula</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Fecha de Registro</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($clientes->count() > 0)
                                    @foreach ($clientes as $cliente)
                                        <tr>
                                            <td>{{ $cliente->cedula_cli }}</td>
                                            <td>{{ $cliente->nombre_cli }}</td>
                                            <td>{{ $cliente->correo_cli }}</td>
                                            <td>{{ $cliente->telefono_cli }}</td>
                                            <td>{{ $cliente->direccion_cli }}</td>
                                            <td>{{ \Carbon\Carbon::parse($cliente->created_at)->format('d-m-Y') }}</td>
                                            <td>
                                                <!-- Botón de Editar -->
                                                <a href="{{ route('clientes.edit', $cliente->cedula_cli) }}" class="btn btn-warning btn-sm">
                                                    <i class="glyphicon glyphicon-pencil"></i> Editar
                                                </a>

                                                <!-- Formulario de eliminación con el botón de Eliminar -->
                                                <form action="{{ route('clientes.destroy', $cliente->cedula_cli) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este cliente?');">
                                                        <i class="glyphicon glyphicon-trash"></i> Eliminar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">No hay clientes disponibles.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        <!-- Paginación -->
                        <div class="d-flex justify-content-center">
                            {{ $clientes->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
