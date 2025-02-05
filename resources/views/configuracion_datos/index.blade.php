@extends('plantilla.plantilla')

@section('content')
    <div class="container">
        <h2>Configuración del Negocio</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($configuracion)
            <table class="table">
                <tr><th>RUC del Emisor:</th><td>{{ $configuracion->ruc_emisor }}</td></tr>
                <tr><th>Nombre del Negocio:</th><td>{{ $configuracion->nombre_negocio }}</td></tr>
                <tr><th>Dirección:</th><td>{{ $configuracion->direccion_negocio }}</td></tr>
                <tr><th>Teléfono:</th><td>{{ $configuracion->telefono_negocio }}</td></tr>
                <tr><th>Correo:</th><td>{{ $configuracion->correo_negocio }}</td></tr>
                <tr><th>Establecimiento:</th><td>{{ $configuracion->codigo_establecimiento }}</td></tr>
                <tr><th>Punto de emisión:</th><td>{{ $configuracion->codigo_emision }}</td></tr>
            </table>

            <a href="{{ route('configuracion_datos.edit', $configuracion->id) }}" class="btn btn-warning">Editar Configuración</a>
        @else
            <a href="{{ route('configuracion_datos.create') }}" class="btn btn-success">Crear Configuración</a>
        @endif
    </div>
@endsection
