@extends('plantilla.plantilla')

@section('content')
    <div class="container-fluid">
        <!-- Sección de métricas -->
        <div class="row">
            <div class="col-md-3">
                <div class="panel-card" style="background-color: #f0ad4e;">
                    <h3 class="text-black"><i class="glyphicon glyphicon-briefcase"></i> Total Proveedores</h3>
                    <p style="font-size: 24px;">{{ $proveedores->count() }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel-card" style="background-color: #5bc0de;">
                    <h3 class="text-black"><i class="glyphicon glyphicon-check"></i> Activos</h3>
                    <p style="font-size: 24px;">{{ $proveedores->where('activo_pro', 1)->count() }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel-card" style="background-color: #5cb85c;">
                    <h3 class="text-black"><i class="glyphicon glyphicon-pushpin"></i> Inactivos</h3>
                    <p style="font-size: 24px;">{{ $proveedores->where('activo_pro', 0)->count() }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel-card" style="background-color: #d9534f;">
                    <h3 class="text-black"><i class="glyphicon glyphicon-time"></i> Última Edición</h3>
                    <p style="font-size: 24px;">
                        {{ $proveedores->max('updated_at') ? \Carbon\Carbon::parse($proveedores->max('updated_at'))->format('d-m-Y') : 'N/A' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Sección de proveedores -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3><i class="glyphicon glyphicon-list-alt"></i> Lista de Proveedores</h3>
                        </div>
                        <div class="pull-right">
                            @can('crear proveedores')
                                <a href="{{ route('proveedor.create') }}" class="btn btn-info">
                                    <i class="glyphicon glyphicon-plus"></i> Añadir Proveedor
                                </a>
                            @endcan
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        <!-- 🔍 Barra de búsqueda -->
                        <form action="{{ route('proveedor.index') }}" method="GET" class="form-inline" style="margin-bottom: 15px;">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Buscar por RUC o Nombre..."
                                    value="{{ request()->query('search') }}">
                                <span class="input-group-btn">
                                    <button class="btn btn-success" type="submit">
                                        <i class="glyphicon glyphicon-search"></i> Buscar
                                    </button>
                                </span>
                            </div>
                            @if(request()->has('search'))
                                <span style="margin-left: 8px;" class="input-group-btn">
                                    <a href="{{ route('proveedor.index') }}" class="btn btn-danger">
                                        <i class="glyphicon glyphicon-remove"></i> Quitar filtro
                                    </a>
                                </span>
                            @endif
                        </form>

                        <!-- Tabla de proveedores -->
                        <div class="table-container">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>RUC</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Teléfono</th>
                                        <th>Dirección</th>
                                        <th>Activo</th>
                                        <th>Notas</th>
                                        <th>Fecha de Registro</th>
                                        <th>Última Edición</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($proveedores->count())
                                        @foreach ($proveedores as $proveedor)
                                            <tr>
                                                <td>{{ $proveedor->ruc_pro }}</td>
                                                <td>{{ $proveedor->nombre_pro }}</td>
                                                <td>{{ $proveedor->correo_pro }}</td>
                                                <td>{{ $proveedor->telefono_pro }}</td>
                                                <td>{{ $proveedor->direccion_pro }}</td>
                                                <td>{{ $proveedor->activo_pro ? 'Sí' : 'No' }}</td>
                                                <td>{{ $proveedor->notas_pro }}</td>
                                                <td>{{ \Carbon\Carbon::parse($proveedor->created_at)->format('d-m-Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($proveedor->updated_at)->format('d-m-Y') }}</td>
                                                <td>
                                                    @can('editar proveedores')
                                                        <a href="{{ route('proveedor.edit', $proveedor->ruc_pro) }}"
                                                            class="btn btn-warning btn-sm"
                                                            style="border-radius: 5px; padding: 5px 10px;">
                                                            <i class="glyphicon glyphicon-pencil"></i> Editar
                                                        </a>
                                                    @endcan

                                                    @can('eliminar proveedores')
                                                        <form action="{{ route('proveedor.destroy', $proveedor->ruc_pro) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                style="border-radius: 5px; padding: 5px 10px;"
                                                                onclick="return confirm('¿Está seguro de eliminar este proveedor?');">
                                                                <i class="glyphicon glyphicon-trash"></i> Eliminar
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" class="text-center">No hay registros disponibles.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer text-center">
                        {{ $proveedores->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
