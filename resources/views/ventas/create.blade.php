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
                        <h3 class="panel-title">Nueva Venta</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-container">
                            <form method="POST" action="{{ route('ventas.store') }}" role="form">
                                {{ csrf_field() }}

                                <h4>Datos de la Venta</h4>
                                <h4>Clave de Acceso (Datos para generar la ID de la venta)</h4>

                                <div class="row">
                                    <div class="col-xs-4">
                                        <label for="ruc_emisor">RUC del Emisor</label>
                                        <input type="text" id="ruc_emisor" class="form-control input-sm"
                                            value="{{ $configuracion->ruc_emisor ?? '' }}" readonly>
                                    </div>
                                    <div class="col-xs-2">
                                        <label for="tipo_comprobante">T. Comprobante</label>
                                        <input type="text" id="tipo_comprobante" class="form-control input-sm"
                                            value="01" readonly>
                                    </div>
                                    <div class="col-xs-2">
                                        <label for="ambiente">Ambiente</label>
                                        <input type="text" id="ambiente" class="form-control input-sm" value="2"
                                            readonly>
                                    </div>
                                    <div class="col-xs-2">
                                        <label for="codigo_establecimiento">Establecimiento</label>
                                        <input type="text" id="codigo_establecimiento" class="form-control input-sm"
                                            value="{{ $configuracion->codigo_establecimiento ?? '' }}" readonly>
                                    </div>
                                    <div class="col-xs-2">
                                        <label for="codigo_emision">Punto de Emisión</label>
                                        <input type="text" id="codigo_emision" class="form-control input-sm"
                                            value="{{ $configuracion->codigo_emision ?? '' }}" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <label for="numero_factura_string">Número de Factura (String)</label>
                                            <input type="text" id="numero_factura_string" class="form-control input-sm"
                                                value="{{ str_pad($numeroFactura, 9, '0', STR_PAD_LEFT) }}" readonly>
                                        </div>

                                        <div class="col-xs-6">
                                            <label for="numero_factura">Número de Factura (Entero - Se enviará)</label>
                                            <input type="text" name="venta[numero_factura]" id="numero_factura"
                                                class="form-control input-sm">
                                        </div>


                                        <div class="col-xs-6">
                                            <label for="codigo_aleatorio">Código Aleatorio</label>
                                            <input type="text" id="codigo_aleatorio" class="form-control input-sm"
                                                value="{{ $codigoAleatorio }}" readonly>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-xs-6">
                                        <label for="id_ven">ID de la Venta</label>
                                        <input type="text" name="venta[id_ven]" id="id_ven"
                                            class="form-control input-sm" readonly required>
                                    </div>
                                    <div class="col-xs-6">
                                        <button type="button" class="btn btn-primary btn-block"
                                            onclick="generarCodigoVenta()">Generar Código</button>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <label for="cedula_cli">ID de Cliente</label>
                                    <select name="venta[cedula_cli]" id="cedula_cli" class="form-control input-sm"
                                        onchange="updateClienteDetails()">
                                        <option value="" disabled selected>Seleccione una ID de Cliente</option>
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->cedula_cli }}"
                                                data-nombre="{{ $cliente->nombre_cli }}"
                                                data-cedula="{{ $cliente->cedula_cli }}" data-id="{{ $cliente->id }}">
                                                {{ $cliente->cedula_cli }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6">
                                        <label for="nombre_cli_ven">Nombre del Cliente</label>
                                        <input type="text" name="venta[nombre_cli_ven]" id="nombre_cli_ven"
                                            class="form-control input-sm" readonly required>
                                    </div>
                                    <div class="col-xs-6">
                                        <label for="cedula_id">Cédula del Cliente</label>
                                        <input type="text" name="venta[cedula_id]" id="cedula_id"
                                            class="form-control input-sm" readonly required>
                                    </div>
                                    <div class="col-xs-6">
                                        <label for="fecha_emision_ven">Fecha de Emisión</label>
                                        <input type="date" name="venta[fecha_emision_ven]" id="fecha_emision_ven"
                                            class="form-control input-sm" readonly required>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-xs-6">
                                        <label for="total_venta">Total de la Venta:</label>
                                        <input type="text" id="total_venta" class="form-control input-sm" readonly>
                                    </div>
                                </div>


                                <h4>Detalles de la Venta</h4>
                                <div id="detalles-container">
                                    <div class="detalle-item">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <label for="nombre_producto">Producto</label>
                                                <select name="detalles[0][nombre_producto]"
                                                    class="form-control input-sm producto-select" required
                                                    onchange="updateProductoDetails(0); disableSelectedProducts(); calculateSubtotal(0);">
                                                    <option value="" disabled selected>Seleccione un Producto
                                                    </option>
                                                    @foreach ($productos as $producto)
                                                        <option value="{{ $producto->nombre_pro }}"
                                                            data-codigo="{{ $producto->codigo_pro }}"
                                                            data-descripcion="{{ $producto->descripcion_pro }}"
                                                            data-precio="{{ $producto->precio_unitario_pro }}"
                                                            data-stock="{{ $producto->stock_pro }}">

                                                            {{ $producto->nombre_pro }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xs-3">
                                                <label for="codigo_pro">Código Producto</label>
                                                <input type="text" class="form-control input-sm codigo-pro-visible"
                                                    placeholder="Código Producto" readonly>
                                                <input type="hidden" name="detalles[0][codigo_pro]" class="codigo-pro">
                                            </div>
                                            <div class="col-xs-3">
                                                <label for="stock_disponible">Stock Disponible</label>
                                                <input type="text" class="form-control input-sm stock-disponible"
                                                    placeholder="Stock Disponible" readonly>
                                            </div>

                                            <div class="col-xs-3">
                                                <label for="cantidad_pro_detven">Cantidad</label>
                                                <input type="number" name="detalles[0][cantidad_pro_detven]"
                                                    class="form-control input-sm cantidad-producto" placeholder="Cantidad"
                                                    required min="1" oninput="calculateSubtotal(0)">
                                            </div>
                                            <div class="col-xs-3">
                                                <label for="precio_unitario">Precio Unitario</label>
                                                <input type="number" class="form-control input-sm precio-unitario"
                                                    placeholder="Precio Unitario" step="0.01" required min="1"
                                                    readonly>

                                                <!-- Campo oculto para enviar el precio unitario -->
                                                <input type="hidden" name="detalles[0][precio_unitario_detven]"
                                                    class="precio-unitario-hidden">

                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <label for="tipo_venta">Tipo de Venta</label>
                                            <select name="detalles[0][tipo_venta]"
                                                class="form-control input-sm tipo-venta" required>
                                                <option value="" disabled selected>Seleccione el tipo</option>
                                                <option value="UNIDAD">UNIDAD</option>
                                                <option value="LIBRAS">LIBRAS</option>
                                            </select>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-3">
                                                <label for="iva_detven">IVA %</label>
                                                <input type="number" name="detalles[0][iva_detven]"
                                                    class="form-control input-sm iva-producto" placeholder="IVA %"
                                                    step="0.01" required min="0" value="0"
                                                    oninput="calculateSubtotal(0)">
                                            </div>
                                            <div class="col-xs-3">
                                                <label for="subtotal_detven">Subtotal</label>
                                                <input type="text" class="form-control input-sm subtotal-producto"
                                                    placeholder="Subtotal" readonly>
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
                                        <a href="{{ route('ventas.index') }}" class="btn btn-info btn-block">Atrás</a>
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
        // Función para actualizar el nombre y cédula del cliente cuando se selecciona una ID de cliente
        function updateClienteDetails() {
            var select = document.getElementById('cedula_cli');
            var nombreField = document.getElementById('nombre_cli_ven');
            var cedulaField = document.getElementById('cedula_id');
            var selectedOption = select.options[select.selectedIndex];

            // Obtener los valores de los atributos de la opción seleccionada
            var nombreCliente = selectedOption.getAttribute('data-nombre');
            var cedulaCliente = selectedOption.getAttribute('data-cedula');

            // Asignar los valores a los campos correspondientes
            nombreField.value = nombreCliente;
            cedulaField.value = cedulaCliente; // Actualizamos la cédula del cliente
        }

        function updateProductoDetails(index) {
            let select = document.querySelectorAll('.producto-select')[index];
            if (!select) return; // Evita errores si el elemento no existe

            let selectedOption = select.options[select.selectedIndex];
            if (!selectedOption) return; // Si no hay opción seleccionada, no hacer nada

            // Obtener los campos correspondientes en la fila actual
            let codigoVisibleField = document.querySelectorAll('.codigo-pro-visible')[index];
            let codigoField = document.querySelectorAll('.codigo-pro')[index];
            let precioField = document.querySelectorAll('.precio-unitario')[index];
            let descripcionField = document.querySelectorAll('.descripcion-producto')[index];

            // Asignar los valores del producto seleccionado
            if (codigoVisibleField) codigoVisibleField.value = selectedOption.getAttribute('data-codigo');
            if (codigoField) codigoField.value = selectedOption.getAttribute('data-codigo');
            if (precioField) precioField.value = selectedOption.getAttribute('data-precio');
            if (descripcionField) descripcionField.value = selectedOption.getAttribute('data-descripcion');
        }

        function generarCodigoVenta() {
            let fecha = document.getElementById('fecha_emision_ven').value;
            let partesFecha = fecha.split('-'); // Divide la fecha en [YYYY, MM, DD]
            let fechaFormateada = partesFecha[2] + partesFecha[1] + partesFecha[0]; // Convierte a DDMMAAAA

            let ruc = document.getElementById('ruc_emisor').value;
            let tipo = document.getElementById('tipo_comprobante').value;
            let ambiente = document.getElementById('ambiente').value;
            let establecimiento = document.getElementById('codigo_establecimiento').value;
            let puntoemision = document.getElementById('codigo_emision').value;

            let numeroFacturaString = document.getElementById('numero_factura_string').value.padStart(9,
                '0'); // Asegurar 9 dígitos con ceros
            let codigoAleatorio = document.getElementById('codigo_aleatorio').value.padStart(8, '0');

            let claveSinDigito = fechaFormateada + tipo + ruc + ambiente + establecimiento + puntoemision +
                numeroFacturaString +
                codigoAleatorio;
            let digitoVerificador = calcularModulo11(claveSinDigito);
            let claveAcceso = claveSinDigito + digitoVerificador;

            document.getElementById('id_ven').value = claveAcceso;

            /// 🔹 Aquí convertimos `numero_factura_string` en entero y lo pasamos al campo correcto
            let numeroFacturaEntero = parseInt(numeroFacturaString, 10); // Convertir a entero
            document.getElementById('numero_factura').value = numeroFacturaEntero; // Asignarlo al campo que se enviará

        }



        function calcularModulo11(clave) {
            let suma = clave.split('').reverse().reduce((acc, num, i) => acc + num * (2 + (i % 6)), 0);
            let residuo = suma % 11;
            return residuo === 10 ? 1 : (residuo === 11 ? 0 : 11 - residuo);
        }


        // Función para autocompletar la fecha actual en el campo de fecha de emisión
        document.getElementById('fecha_emision_ven').value = new Date().toISOString().split('T')[0];


        function disableSelectedProducts() {
            let selected = Array.from(document.querySelectorAll('.producto-select')).map(select => select.value);
            document.querySelectorAll('.producto-select option').forEach(option => {
                option.disabled = selected.includes(option.value) && option.value !== "";
            });
        }

        let detalleIndex = 1;

        function agregarDetalle() {
            let container = document.getElementById('detalles-container');
            let totalProductos = {{ count($productos) }};
            let detallesActuales = container.querySelectorAll('.detalle-item').length;

            if (detallesActuales >= totalProductos) {
                alert('No puedes agregar más detalles que el número de productos registrados.');
                return;
            }

            let newDetalle = document.querySelector('.detalle-item').cloneNode(true);

            // Reemplazar los índices de los nuevos inputs y selects
            newDetalle.querySelectorAll('input, select').forEach(el => {
                if (el.name) el.name = el.name.replace(/\d+/, detallesActuales);
                if (el.id) el.id = el.id.replace(/\d+/, detallesActuales);
                el.value = ''; // Limpiar valores
            });

            // Asignar eventos dinámicos para cálculos automáticos
            newDetalle.querySelector('.producto-select').onchange = function() {
                updateProductoDetails(detallesActuales);
                disableSelectedProducts();
                calculateSubtotal(detallesActuales);
            };
            newDetalle.querySelector('.cantidad-producto').oninput = function() {
                calculateSubtotal(detallesActuales);
            };
            newDetalle.querySelector('.iva-producto').oninput = function() {
                calculateSubtotal(detallesActuales);
            };

            // Agregar el nuevo detalle al contenedor
            container.appendChild(newDetalle);
            disableSelectedProducts(); // Actualizar productos deshabilitados
        }


        function eliminarDetalle(button) {
            button.closest('.detalle-item').remove();
            disableSelectedProducts();
        }

        function updateProductoDetails(index) {
            let select = document.querySelectorAll('.producto-select')[index];
            if (!select) return; // Evita errores si el elemento no existe

            let selectedOption = select.options[select.selectedIndex];
            if (!selectedOption) return; // Si no hay opción seleccionada, no hacer nada

            // Obtener los campos correspondientes en la fila actual
            let codigoVisibleField = document.querySelectorAll('.codigo-pro-visible')[index];
            let codigoField = document.querySelectorAll('.codigo-pro')[index];
            let precioField = document.querySelectorAll('.precio-unitario')[index];
            let precioHiddenField = document.querySelectorAll('.precio-unitario-hidden')[index]; // ✅ Agregado
            let descripcionField = document.querySelectorAll('.descripcion-producto')[index];
            let stockField = document.querySelectorAll('.stock-disponible')[index]; // ✅ Nuevo campo para el stock


            let precio = selectedOption.getAttribute('data-precio');
            let stock = selectedOption.getAttribute('data-stock'); // Obtener stock del producto

            // Asignar los valores del producto seleccionado
            if (codigoVisibleField) codigoVisibleField.value = selectedOption.getAttribute('data-codigo');
            if (codigoField) codigoField.value = selectedOption.getAttribute('data-codigo');
            if (precioField) precioField.value = precio;
            if (precioHiddenField) precioHiddenField.value = precio; // ✅ Ahora el campo oculto se llena correctamente
            if (descripcionField) descripcionField.value = selectedOption.getAttribute('data-descripcion');
            if (stockField) stockField.value = stock; // ✅ Mostrar stock disponible

        }




        ////
        document.addEventListener('change', function(event) {
            if (event.target.classList.contains('producto-select')) {
                let index = Array.from(document.querySelectorAll('.producto-select')).indexOf(event.target);
                updateProductoDetails(index);
                disableSelectedProducts();
            }
        });

        function calculateSubtotal(index) {
            let cantidadElements = document.querySelectorAll('.cantidad-producto');
            let precioElements = document.querySelectorAll('.precio-unitario');
            let ivaElements = document.querySelectorAll('.iva-producto');
            let subtotalElements = document.querySelectorAll('.subtotal-producto');
            let stockElements = document.querySelectorAll('.stock-disponible'); // ✅ Agregado para validar stock

            if (cantidadElements[index] && precioElements[index] && ivaElements[index] && subtotalElements[index] &&
                stockElements[index]) {
                let cantidad = parseFloat(cantidadElements[index].value) || 0;
                let precioUnitario = parseFloat(precioElements[index].value) || 0;
                let iva = parseFloat(ivaElements[index].value) || 0;
                let stockDisponible = parseFloat(stockElements[index].value) || 0; // ✅ Obtener stock disponible

                // 🔹 Verificar si la cantidad excede el stock disponible
                if (cantidad > stockDisponible) {
                    alert("⚠️ No hay suficiente stock disponible. Se ajustará al máximo permitido.");
                    cantidad = stockDisponible; // Ajustar cantidad al stock disponible
                    cantidadElements[index].value = stockDisponible; // Reflejar el cambio en el campo de cantidad
                }

                let subtotal = cantidad * precioUnitario * (1 + iva / 100);
                subtotalElements[index].value = subtotal.toFixed(2);
            }

            // 🔹 Recalcular el total de la venta
            calcularTotalVenta();
        }



        function calcularTotalVenta() {
            let subtotales = document.querySelectorAll('.subtotal-producto');
            let total = 0;

            subtotales.forEach(subtotal => {
                total += parseFloat(subtotal.value) || 0;
            });

            // Actualizar el campo "Total de la Venta"
            document.getElementById('total_venta').value = total.toFixed(2);
        }
    </script>
@endsection

@endsection
