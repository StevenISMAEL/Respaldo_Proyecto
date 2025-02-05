@extends('plantilla.plantilla')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <section class="content">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h3><i class="glyphicon glyphicon-list-alt"></i> Lista de Compras</h3>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('compras.create') }}" class="btn btn-success">
                                    <i class="glyphicon glyphicon-plus"></i> Añadir Compra
                                </a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <!-- 🔍 Barra de búsqueda -->
                            <form action="{{ route('compras.index') }}" method="GET" class="form-inline" style="margin-bottom: 15px;">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Buscar por ID o RUC..."
                                        value="{{ request()->query('search') }}">
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" type="submit">
                                            <i class="glyphicon glyphicon-search"></i> Buscar
                                        </button>
                                    </span>
                                    @if(request()->has('search') && request('search') !== '')
                                        <span style="margin-left: 8px;" class="input-group-btn">
                                            <a href="{{ route('compras.index') }}" class="btn btn-danger">
                                                <i class="glyphicon glyphicon-remove"></i> Quitar Filtro
                                            </a>
                                        </span>
                                    @endif
                                </div>
                            </form>

                            <!-- Tabla de compras -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID Compra</th>
                                            <th>RUC Proveedor</th>
                                            <th>Fecha de Emisión</th>
                                            <th>Total Compra</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($compras->count())
                                            @foreach ($compras as $compra)
                                                <tr>
                                                    <td>{{ $compra->id_com }}</td>
                                                    <td>{{ $compra->ruc_pro }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($compra->fecha_emision_com)->format('d-m-Y') }}</td>
                                                    <td>${{ number_format($compra->total_com, 2) }}</td>
                                                    <td>
                                                        <button class="btn btn-primary btn-sm detalles-btn" data-id="{{ $compra->id_com }}">
                                                            <i class="glyphicon glyphicon-eye-open"></i> Detalles
                                                        </button>
                                                        <a href="{{ route('compras.edit', $compra->id_com) }}" class="btn btn-warning btn-sm">
                                                            <i class="glyphicon glyphicon-pencil"></i> Editar
                                                        </a>
                                                        <form action="{{ route('compras.destroy', $compra->id_com) }}" method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta compra?');">
                                                                <i class="glyphicon glyphicon-trash"></i> Eliminar
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <!-- Detalles ocultos de la compra -->
                                                <tr id="detalles-{{ $compra->id_com }}" class="detalles-compra" style="display: none;">
                                                    <td colspan="5">
                                                        <strong>Detalles de la Compra:</strong>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID Detalle</th>
                                                                    <th>ID Compra</th>
                                                                    <th>Código Producto</th>
                                                                    <th>Descripción</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Precio Unitario</th>
                                                                    <th>IVA (%)</th>
                                                                    <th>Subtotal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($compra->detalles as $detalle)
                                                                    <tr>
                                                                        <td>{{ $detalle->id_detcom }}</td>
                                                                        <td>{{ $detalle->id_com }}</td>
                                                                        <td>{{ $detalle->codigo_pro }}</td>
                                                                        <td>{{ $detalle->producto->descripcion_pro }}</td>
                                                                        <td>{{ $detalle->cantidad_pro_detcom }}</td>
                                                                        <td>${{ number_format($detalle->precio_unitario_com, 2) }}</td>
                                                                        <td>{{ $detalle->iva_detcom }}%</td>
                                                                        <td>${{ number_format($detalle->subtotal_detcom, 2) }}</td>
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
                            {{ $compras->links() }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    // ✅ Función para mostrar u ocultar los detalles de la compra
    $(document).ready(function () {
        $(".detalles-btn").on("click", function () {
            var id = $(this).data("id");
            var detalles = $("#detalles-" + id);
            if (detalles.is(":visible")) {
                detalles.hide();
            } else {
                detalles.show();
            }
        });
    });
</script>
@endsection
