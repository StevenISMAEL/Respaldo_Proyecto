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
                        <h3 class="panel-title">Nueva Compra</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-container">
                            <form method="POST" action="{{ route('compras.store') }}" role="form">
                                {{ csrf_field() }}

                                <h4>Datos de la Compra</h4>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <input type="text" name="compra[id_com]" id="id_com"
                                                class="form-control input-sm" placeholder="ID de la compra" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <select name="compra[nombre_proveedor_com]" id="nombre_proveedor_com"
                                                class="form-control input-sm" required onchange="updateProveedorDetails()">
                                                <option value="" disabled selected>Seleccione un Proveedor</option>
                                                @foreach ($proveedores as $proveedor)
                                                    <option value="{{ $proveedor->nombre_pro }}"
                                                        data-ruc="{{ $proveedor->ruc_pro }}">{{ $proveedor->nombre_pro }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <input type="text" id="ruc_pro_visible" class="form-control input-sm"
                                                placeholder="RUC Proveedor" readonly>
                                            <input type="hidden" name="compra[ruc_pro]" id="ruc_pro">
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <input type="date" name="compra[fecha_emision_com]" id="fecha_emision_com"
                                                class="form-control input-sm" readonly required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label for="total_compra">Total de la Compra:</label>
                                            <input type="text" id="total_compra" class="form-control input-sm" readonly>
                                        </div>
                                    </div>
                                </div>

                                <h4>Detalles de la Compra</h4>
                                <div id="detalles-container">
                                    <div class="detalle-item">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <div class="form-group">
                                                    <select name="detalles[0][nombre_producto]"
                                                        class="form-control input-sm producto-select" required
                                                        onchange="updateProductoDetails(0); disableSelectedProducts();">
                                                        <option value="" disabled selected>Seleccione un Producto
                                                        </option>
                                                        @foreach ($productos as $producto)
                                                            <option value="{{ $producto->nombre_pro }}"
                                                                data-codigo="{{ $producto->codigo_pro }}"
                                                                data-descripcion="{{ $producto->descripcion_pro }}"
                                                                data-precio="{{ $producto->precio_unitario_pro }}">
                                                                {{ $producto->nombre_pro }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-sm codigo-pro-visible"
                                                        placeholder="Código Producto" readonly>
                                                    <input type="hidden" name="detalles[0][codigo_pro]" class="codigo-pro">
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-sm descripcion-producto"
                                                        placeholder="Descripción del Producto" readonly>
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <div class="form-group">
                                                    <input type="number" name="detalles[0][cantidad_pro_detcom]"
                                                        class="form-control input-sm cantidad-producto"
                                                        placeholder="Cantidad" required min="1"
                                                        oninput="calculateSubtotal(0)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <div class="form-group">
                                                    <input type="number" name="detalles[0][precio_unitario_com]"
                                                        class="form-control input-sm precio-unitario"
                                                        placeholder="Precio de Compra" step="0.01" required
                                                        min="1" oninput="calculateSubtotal(0)">
                                                </div>
                                            </div>
                                            <div class="col-xs-2">
                                                <div class="form-group">
                                                    <input type="number" name="detalles[0][iva_detcom]"
                                                        class="form-control input-sm iva-producto" placeholder="IVA %"
                                                        step="0.01" required min="0" value="0"
                                                        oninput="calculateSubtotal(0)">
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-sm subtotal-producto"
                                                        placeholder="Subtotal" readonly>
                                                </div>
                                            </div>
                                            <div class="col-xs-2">
                                                <button type="button" class="btn btn-danger"
                                                    onclick="eliminarDetalle(this); disableSelectedProducts();">Eliminar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-info"
                                    onclick="agregarDetalle(); disableSelectedProducts();">Añadir Producto</button>

                                <div class="row mt-4">
                                    <div class="col-xs-12">
                                        <input type="submit" value="Guardar" class="btn btn-success btn-block">
                                        <a href="{{ route('compras.index') }}" class="btn btn-info btn-block">Atrás</a>
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
        function disableSelectedProducts() {
            let selected = Array.from(document.querySelectorAll('.producto-select')).map(select => select.value);
            document.querySelectorAll('.producto-select option').forEach(option => {
                option.disabled = selected.includes(option.value) && option.value !== "";
            });
        }
        let detalleIndex = 1;
        document.getElementById('fecha_emision_com').value = new Date().toISOString().split('T')[0];

        function agregarDetalle() {
            let container = document.getElementById('detalles-container');
            let totalProductos = {{ count($productos) }};
            let detallesActuales = container.querySelectorAll('.detalle-item').length;

            if (detallesActuales >= totalProductos) {
                alert('No puedes agregar más detalles que el número de productos registrados.');
                return;
            }

            let newDetalle = document.querySelector('.detalle-item').cloneNode(true);
            newDetalle.querySelectorAll('input, select').forEach(el => {
                el.name = el.name.replace(/\d+/, detallesActuales);
                el.id = el.id.replace(/\d+/, detallesActuales);
                el.value = '';
            });

            // Asignar eventos a los nuevos campos
            newDetalle.querySelector('.producto-select').onchange = function() {
                updateProductoDetails(detallesActuales);
                disableSelectedProducts();
            };
            newDetalle.querySelector('.cantidad-producto').oninput = function() {
                calculateSubtotal(detallesActuales);
            };
            newDetalle.querySelector('.precio-unitario').oninput = function() {
                calculateSubtotal(detallesActuales);
            };
            newDetalle.querySelector('.iva-producto').oninput = function() {
                calculateSubtotal(detallesActuales);
            };

            container.appendChild(newDetalle);
            detalleIndex++;
            disableSelectedProducts();
        }

        function eliminarDetalle(button) {
            button.closest('.detalle-item').remove();
        }

        function updateProveedorDetails() {
            let select = document.getElementById('nombre_proveedor_com');
            let rucVisibleField = document.getElementById('ruc_pro_visible');
            let rucField = document.getElementById('ruc_pro');
            let selectedOption = select.options[select.selectedIndex];
            rucVisibleField.value = selectedOption.getAttribute('data-ruc');
            rucField.value = selectedOption.getAttribute('data-ruc');
        }

        function updateProductoDetails(index) {
            let select = document.querySelectorAll('.producto-select')[index];
            let descripcionField = document.querySelectorAll('.descripcion-producto')[index];
            let codigoVisibleField = document.querySelectorAll('.codigo-pro-visible')[index];
            let codigoField = document.querySelectorAll('.codigo-pro')[index];
            let precioField = document.querySelectorAll('.precio-unitario')[index];

            let selectedOption = select.options[select.selectedIndex];
            if (selectedOption) {
                descripcionField.value = selectedOption.getAttribute('data-descripcion');
                codigoVisibleField.value = selectedOption.getAttribute('data-codigo');
                codigoField.value = selectedOption.getAttribute('data-codigo');
                precioField.value = selectedOption.getAttribute('data-precio');
            }
        }






        function calcularTotal() {
            let subtotales = document.querySelectorAll('.subtotal-producto');
            let total = 0;

            subtotales.forEach(subtotal => {
                total += parseFloat(subtotal.value) || 0;
            });

            // Actualizar el campo "Total de la compra"
            document.getElementById('total_compra').value = total.toFixed(2);
        }

        function calculateSubtotal(index) {
            let cantidad = parseFloat(document.querySelectorAll('.cantidad-producto')[index].value) || 0;
            let precioUnitario = parseFloat(document.querySelectorAll('.precio-unitario')[index].value) || 0;
            let iva = parseFloat(document.querySelectorAll('.iva-producto')[index].value) || 0;

            let subtotal = cantidad * precioUnitario * (1 + iva / 100);
            document.querySelectorAll('.subtotal-producto')[index].value = subtotal.toFixed(2);

            // Llamar a la función para recalcular el total
            calcularTotal();
        }
    </script>
@endsection
@endsection
