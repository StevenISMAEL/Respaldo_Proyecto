@extends('plantilla.plantilla')

@section('content')
    <div class="row">
        <section class="content">
            <div class="col-md-12">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lista de Compras</h3>
                    </div>
                    <div class="panel-body">
                        <div class="d-flex justify-content-between mb-3">
                            <a href="{{ route('compras.create') }}" class="btn btn-success">Añadir Compra</a>
                        </div>
                        <div class="table-container">
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
                                                    <button class="btn btn-primary btn-sm" onclick="toggleDetalles('{{ $compra->id_com }}')">
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
                                            <!-- Fila oculta con detalles de la compra -->
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
                                            <td colspan="5">No hay registros disponibles.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $compras->links() }}
                </div>
            </div>
        </section>
    </div>

@section('scripts')
    <script>
        // Función para mostrar u ocultar los detalles de la compra
        function toggleDetalles(id) {
            let detalles = document.getElementById("detalles-" + id);
            if (detalles.style.display === "none" || detalles.style.display === "") {
                detalles.style.display = "table-row";
            } else {
                detalles.style.display = "none";
            }
        }
    </script>
@endsection
@endsection
