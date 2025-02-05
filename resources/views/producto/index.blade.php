@extends('plantilla.plantilla')

@section('content')
    <div class="container-fluid">
        <!-- Tarjetas de métricas -->
        <div class="row text-center">
            <div class="col-md-3">
                <div class="panel-card" style="background-color: #f0ad4e; color: black;">
                    <h3><i class="glyphicon glyphicon-list-alt"></i> Total Productos</h3>
                    <p style="font-size: 24px; color: black;">{{ $productos->count() }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel-card" style="background-color: #5bc0de; color: black;">
                    <h3><i class="glyphicon glyphicon-apple"></i> Productos Alimenticios</h3>
                    <p style="font-size: 24px; color: black;">{{ $productos->where('alimenticio_pro', true)->count() }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel-card" style="background-color: #5cb85c; color: black;">
                    <h3><i class="glyphicon glyphicon-usd"></i> Precio Promedio</h3>
                    <p style="font-size: 24px; color: black;">${{ number_format($productos->avg('precio_unitario_pro'), 2) }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel-card" style="background-color: #d9534f; color: black;">
                    <h3><i class="glyphicon glyphicon-tag"></i> Último Producto</h3>
                    <p style="font-size: 24px; color: black;">{{ $productos->sortByDesc('created_at')->first()->nombre_pro ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Lista de productos -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">
                                <i class="glyphicon glyphicon-th-list"></i> Lista de Productos
                            </h3>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('productos.create') }}" class="btn btn-success">
                                <i class="glyphicon glyphicon-plus"></i> Añadir Producto
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <!-- Barra de búsqueda con margen inferior -->
                        <form action="{{ route('productos.index') }}" method="GET" class="form-inline" style="margin-bottom: 15px;">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Buscar por código o nombre..."
                                    value="{{ request()->query('search') }}">
                                <span class="input-group-btn">
                                    <button class="btn btn-success" type="submit">
                                        <i class="glyphicon glyphicon-search"></i> Buscar
                                    </button>
                                </span>
                                @if(request()->has('search') && request('search') !== '')
                                    <span style="margin-left: 8px;" class="input-group-btn">
                                        <a href="{{ route('productos.index') }}" class="btn btn-danger">
                                            <i class="glyphicon glyphicon-remove"></i> Quitar Filtro
                                        </a>
                                    </span>
                                @endif
                            </div>
                        </form>

                        <!-- Tabla de productos -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Precio Unitario</th>
                                        <th>Stock</th>
                                        <th>Mínimo</th>
                                        <th>Máximo</th>
                                        <th>Precio por Libra</th>
                                        <th>Descripción</th>
                                        <th>¿Alimenticio?</th>
                                        <th>Tipo Animal</th>
                                        <th>Tamaño/Raza</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($productos->count())
                                        @foreach ($productos as $producto)
                                            <tr>
                                                <td>{{ $producto->codigo_pro }}</td>
                                                <td>{{ $producto->nombre_pro }}</td>
                                                <td>${{ number_format($producto->precio_unitario_pro, 2) }}</td>
                                                <td>{{ $producto->stock_pro ?? 'N/A' }}</td>
                                                <td>{{ $producto->minimo_pro ?? 'N/A' }}</td>
                                                <td>{{ $producto->maximo_pro ?? 'N/A' }}</td>
                                                <td>{{ $producto->alimenticio_pro ? number_format($producto->precio_libras_pro, 2) . ' $' : 'N/A' }}</td>
                                                <td>{{ $producto->descripcion_pro }}</td>
                                                <td>{{ $producto->alimenticio_pro ? 'Sí' : 'No' }}</td>
                                                <td>{{ $producto->tipo_animal_pro }}</td>
                                                <td>{{ $producto->tamano_raza_pro }}</td>
                                                <td>
                                                    <a href="{{ route('productos.edit', $producto->codigo_pro) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="glyphicon glyphicon-pencil"></i> Editar
                                                    </a>
                                                    <form action="{{ route('productos.destroy', $producto->codigo_pro) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                                                            <i class="glyphicon glyphicon-trash"></i> Eliminar
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="12" class="text-center">No hay registros disponibles.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer">
                        {{ $productos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
