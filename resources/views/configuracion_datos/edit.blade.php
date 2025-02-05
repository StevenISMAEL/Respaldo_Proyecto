@extends('plantilla.plantilla')

@section('content')
    <div class="container">
        <h2>Editar Configuración</h2>

        <form action="{{ route('configuracion_datos.update', $configuracion->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="ruc_emisor" class="form-label">RUC del Emisor</label>
                <input type="text" name="ruc_emisor" class="form-control"
                    value="{{ old('ruc_emisor', $configuracion->ruc_emisor) }}" required maxlength="13">
                @error('ruc_emisor')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nombre_negocio" class="form-label">Nombre del Negocio</label>
                <input type="text" name="nombre_negocio" class="form-control"
                    value="{{ old('nombre_negocio', $configuracion->nombre_negocio) }}" required maxlength="100">
                @error('nombre_negocio')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="direccion_negocio" class="form-label">Dirección del Negocio</label>
                <input type="text" name="direccion_negocio" class="form-control"
                    value="{{ old('direccion_negocio', $configuracion->direccion_negocio) }}" maxlength="200">
                @error('direccion_negocio')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="telefono_negocio" class="form-label">Teléfono del Negocio</label>
                <input type="text" name="telefono_negocio" class="form-control"
                    value="{{ old('telefono_negocio', $configuracion->telefono_negocio) }}" maxlength="15">
                @error('telefono_negocio')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="correo_negocio" class="form-label">Correo Electrónico</label>
                <input type="email" name="correo_negocio" class="form-control"
                    value="{{ old('correo_negocio', $configuracion->correo_negocio) }}" maxlength="100">
                @error('correo_negocio')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="codigo_establecimiento">Código del Establecimiento</label>
                <input type="text" name="codigo_establecimiento" class="form-control"
                    value="{{ $configuracion->codigo_establecimiento }}" required maxlength="3" pattern="\d{3}">
            </div>

            <div class="mb-3">
                <label for="codigo_emision">Código del Punto de Emisión</label>
                <input type="text" name="codigo_emision" class="form-control"
                    value="{{ $configuracion->codigo_emision }}" required maxlength="3" pattern="\d{3}">
            </div>





            <button type="submit" class="btn btn-success">Guardar Cambios</button>
            <a href="{{ route('configuracion_datos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
