@extends('plantilla.plantilla')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <section class="content">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h3><i class="glyphicon glyphicon-list-alt"></i> Lista de Ventas</h3>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('ventas.create') }}" class="btn btn-success">
                                    <i class="glyphicon glyphicon-plus"></i> Nueva Venta
                                </a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <!-- 🔍 Barra de búsqueda -->
                            <form action="{{ route('ventas.index') }}" method="GET" class="form-inline" style="margin-bottom: 15px;">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Buscar por ID o Cliente..."
                                        value="{{ request()->query('search') }}">
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" type="submit">
                                            <i class="glyphicon glyphicon-search"></i> Buscar
                                        </button>
                                    </span>
                                    @if(request()->has('search') && request('search') !== '')
                                        <span style="margin-left: 8px;" class="input-group-btn">
                                            <a href="{{ route('ventas.index') }}" class="btn btn-danger">
                                                <i class="glyphicon glyphicon-remove"></i> Quitar Filtro
                                            </a>
                                        </span>
                                    @endif
                                </div>
                            </form>

                            <!-- Tabla de ventas -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID Venta</th>
                                            <th>Cédula Cliente</th>
                                            <th>Nombre Cliente</th>
                                            <th>Fecha de Emisión</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($ventas->count())
                                            @foreach ($ventas as $venta)
                                                <tr>
                                                    <td>{{ $venta->id_ven }}</td>
                                                    <td>{{ $venta->cedula_cli }}</td>
                                                    <td>{{ $venta->nombre_cli_ven ?? 'No registrado' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($venta->fecha_emision_ven)->format('d-m-Y') }}</td>
                                                    <td>
                                                        <a href="javascript:void(0);" class="btn btn-info btn-sm"
                                                            onclick="toggleDetalles('detalles-{{ $venta->id_ven }}')">
                                                            <i class="glyphicon glyphicon-eye-open"></i> Detalles
                                                        </a>
                                                        <a href="{{ route('ventas.pdf', $venta->id_ven) }}" class="btn btn-success" target="_blank">
                                                            <i class="fas fa-print"></i> Imprimir
                                                        </a>
                                                        <form action="{{ route('ventas.destroy', $venta->id_ven) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta venta?');">
                                                                <i class="glyphicon glyphicon-trash"></i> Eliminar
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>

                                                <!-- Detalles ocultos de la venta -->
                                                <tr id="detalles-{{ $venta->id_ven }}" style="display:none;">
                                                    <td colspan="5">
                                                        <strong>Detalles de la Venta:</strong>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Producto</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Precio Unitario</th>
                                                                    <th>IVA</th>
                                                                    <th>Subtotal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($venta->detalles as $detalle)
                                                                    <tr>
                                                                        <td>{{ $detalle->producto->nombre_pro ?? 'Producto no disponible' }}</td>
                                                                        <td>{{ $detalle->cantidad_pro_detven }}</td>
                                                                        <td>${{ number_format($detalle->precio_unitario_detven, 2) }}</td>
                                                                        <td>{{ $detalle->iva_detven }}%</td>
                                                                        <td>${{ number_format($detalle->subtotal_detven, 2) }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">No hay registros disponibles.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer text-center">
                            {{ $ventas->links() }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

@section('scripts')
    <script>
        // ✅ Función para mostrar/ocultar los detalles de la venta
        function toggleDetalles(id) {
            var detalles = document.getElementById(id);
            if (detalles.style.display === "none" || detalles.style.display === "") {
                detalles.style.display = "table-row";
            } else {
                detalles.style.display = "none";
            }
        }
    </script>
@endsection
@endsection
