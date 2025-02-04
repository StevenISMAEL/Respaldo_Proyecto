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
                        <h3 class="panel-title">Nuevo Producto</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-container">
                            <form method="POST" action="{{ route('productos.store') }}" role="form">
                                {{ csrf_field() }}

                                <!-- Datos del Producto -->
                                <h4>Datos del Producto</h4>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="codigo_pro" id="codigo"
                                                class="form-control input-sm" placeholder="Código del producto" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="nombre_pro" id="nombre"
                                                class="form-control input-sm" placeholder="Nombre del producto" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <textarea name="descripcion_pro" class="form-control input-sm" placeholder="Descripción del producto"></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="number" name="precio_unitario_pro" id="precio_unitario"
                                                class="form-control input-sm" placeholder="Precio unitario" step="0.01"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="alimenticio">¿Producto Alimenticio?</label>
                                            <select name="alimenticio_pro" id="alimenticio" class="form-control input-sm"
                                                required onchange="togglePesoPrecio()">
                                                <option value="1">Sí</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <h4>Especificaciones del Producto</h4>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="tipo_animal_pro" class="form-control input-sm"
                                                placeholder="Tipo de animal" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="tamano_raza_pro" class="form-control input-sm"
                                                placeholder="Tamaño/Raza" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div id="peso-libras-container" class="col-xs-6 col-sm-6 col-md-6"
                                        style="display: none;">
                                        <div class="form-group">
                                            <input type="number" name="peso_libras_pro" class="form-control input-sm"
                                                placeholder="Peso en libras" step="0.01" min="0" value="0">
                                        </div>
                                    </div>
                                    <div id="precio-libras-container" class="col-xs-6 col-sm-6 col-md-6"
                                        style="display: none;">
                                        <div class="form-group">
                                            <input type="number" name="precio_libras_pro" class="form-control input-sm"
                                                placeholder="Precio por libra" step="0.01">
                                        </div>
                                    </div>
                                </div>
                                <h4>Control de Stock</h4>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="number" name="minimo_pro" class="form-control input-sm"
                                                placeholder="Stock mínimo" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="number" name="maximo_pro" class="form-control input-sm"
                                                placeholder="Stock máximo" required>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mt-4">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input type="submit" value="Guardar" class="btn btn-success btn-block">
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
@section('scripts')
    <script>
        // Función para mostrar u ocultar los campos de peso y precio
        function togglePesoPrecio() {
            var alimenticio = document.getElementById('alimenticio').value;
            var pesoContainer = document.getElementById('peso-libras-container');
            var precioContainer = document.getElementById('precio-libras-container');

            if (alimenticio == '1') {
                pesoContainer.style.display = 'block';
                precioContainer.style.display = 'block';
            } else {
                pesoContainer.style.display = 'none';
                precioContainer.style.display = 'none';
            }
        }

        // Llamar a la función para inicializar el estado correcto al cargar la página
        togglePesoPrecio();
    </script>
@endsection

@endsection
