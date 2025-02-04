@extends('plantilla.plantilla')

@section('content')
    <div class="row">
        <section class="content">
            <div class="col-md-8 col-md-offset-2">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Error!</strong> Revise los campos obligatorios.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (Session::has('success'))
                    <div class="alert alert-info">
                        {{ Session::get('success') }}
                    </div>
                @endif

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Editar Producto</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-container">
                            <form method="POST" action="{{ route('productos.update', $producto->codigo_pro) }}" role="form">
                                @csrf
                                @method('PUT')

                                <!-- Datos del Producto -->
                                <h4>Datos del Producto</h4>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="producto[codigo_pro]" id="codigo"
                                                class="form-control input-sm"
                                                value="{{ old('producto.codigo_pro', $producto->codigo_pro) }}"
                                                placeholder="Código del producto" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="producto[nombre_pro]" id="nombre"
                                                class="form-control input-sm"
                                                value="{{ old('producto.nombre_pro', $producto->nombre_pro) }}"
                                                placeholder="Nombre del producto" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <textarea name="producto[descripcion_pro]" class="form-control input-sm"
                                        placeholder="Descripción del producto">{{ old('producto.descripcion_pro', $producto->descripcion_pro) }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="number" name="producto[precio_unitario_pro]" id="precio_unitario"
                                                class="form-control input-sm"
                                                value="{{ old('producto.precio_unitario_pro', $producto->precio_unitario_pro) }}"
                                                placeholder="Precio unitario" step="0.01" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="alimenticio_pro">¿Producto Alimenticio?</label>
                                            <input type="text" class="form-control input-sm"
                                                value="{{ $producto->alimenticio_pro ? 'Sí' : 'No' }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Especificaciones del Producto -->
                                <h4>Especificaciones del Producto</h4>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="producto[tipo_animal_pro]" id="tipo_animal"
                                                class="form-control input-sm"
                                                value="{{ old('producto.tipo_animal_pro', $producto->tipo_animal_pro) }}"
                                                placeholder="Tipo de animal" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="producto[tamano_raza_pro]" id="tamano_raza"
                                                class="form-control input-sm"
                                                value="{{ old('producto.tamano_raza_pro', $producto->tamano_raza_pro) }}"
                                                placeholder="Tamaño/Raza" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Campos de producto alimenticio -->
                                <div id="alimenticio-fields" style="display: {{ $producto->alimenticio_pro ? 'block' : 'none' }};">
                                    <h4>Datos Nutricionales</h4>
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input type="number" name="producto[peso_libras_pro]" id="peso_libras_pro"
                                                    class="form-control input-sm"
                                                    value="{{ old('producto.peso_libras_pro', $producto->peso_libras_pro) }}"
                                                    placeholder="Peso en libras" step="0.01">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input type="number" name="producto[precio_libras_pro]" id="precio_libras_pro"
                                                    class="form-control input-sm"
                                                    value="{{ old('producto.precio_libras_pro', $producto->precio_libras_pro) }}"
                                                    placeholder="Precio por libra" step="0.01">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Control de Stock -->
                                <h4>Control de Stock</h4>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="number" name="producto[minimo_pro]" id="minimo_pro"
                                                class="form-control input-sm"
                                                value="{{ old('producto.minimo_pro', $producto->minimo_pro) }}"
                                                placeholder="Stock mínimo" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="number" name="producto[maximo_pro]" id="maximo_pro"
                                                class="form-control input-sm"
                                                value="{{ old('producto.maximo_pro', $producto->maximo_pro) }}"
                                                placeholder="Stock máximo" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input type="submit" value="Actualizar" class="btn btn-success btn-block">
                                        <a href="{{ route('productos.index') }}" class="btn btn-info btn-block">Atrás</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
