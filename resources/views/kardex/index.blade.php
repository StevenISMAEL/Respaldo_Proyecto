@extends('plantilla.plantilla')

@section('content')
    <div class="row">
        <section class="content">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="pull-left">
                            <h3>Lista de Kardex</h3>
                        </div>
                        {{-- <div class="pull-right">
                            <div class="btn-group">
                                <a href="{{ route('kardex.create') }}" class="btn btn-info">Añadir Kardex</a>
                            </div>
                        </div> --}}
                        <div class="table-container">
                            <table id="mytable" class="table table-bordred table-striped">
                                <thead>
                                    <tr>
                                        <th>ID Kardex</th>
                                        <th>Código Producto</th>
                                        <th>Fecha Registro</th>
                                        <th>Tipo Movimiento</th>
                                        <th>Cantidad</th>
                                        <th>Descripción</th>
                                        <th>Creado</th>
                                        <th>Actualizado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($kardex->count())
                                        @foreach ($kardex as $item)
                                            <tr>
                                                <td>{{ $item->id_kar }}</td>
                                                <td>{{ $item->codigo_pro }}</td>
                                                <td>{{ $item->fecha_registro_kar }}</td>
                                                <td>{{ $item->tipo_movimiento }}</td>
                                                <td>{{ $item->cantidad_movimiento }}</td>
                                                <td>{{ $item->descripcion_movimiento }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ $item->updated_at }}</td>
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
                    {{ $kardex->links() }}
                </div>
            </div>
        </section>
    </div>

@section('scripts')
    <script>
        // Función para mostrar u ocultar los detalles del kardex
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
