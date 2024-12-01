@extends('plantilla.plantilla')

@section('content')
<div class="row">
    <section class="content">
        <div class="col-md-8 col-md-offset-2">
            @if(count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Error!</strong> Revise los campos obligatorios.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Editar Producto del Inventario </h3>
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route('inventario.update', $inventario->codigo) }}" role="form">
                        @csrf
                        @method('PUT') 
                        
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo', $inventario->codigo) }}" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="nombre_producto">Nombre del Producto</label>
                            <input type="text" name="nombre_producto" id="nombre_producto" class="form-control" value="{{ old('nombre_producto', $inventario->nombre_producto) }}" maxlength="40">
                        </div>
                        <div class="form-group">
                            <label for="cantidad_disponible">Cantidad Disponible</label>
                            <input type="number" name="cantidad_disponible" id="cantidad_disponible" class="form-control" step="0.01" value="{{ old('cantidad_disponible', $inventario->cantidad_disponible) }}" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Actualizar</button>
                            <a href="{{ route('inventario.index') }}" class="btn btn-info">Atrás</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
