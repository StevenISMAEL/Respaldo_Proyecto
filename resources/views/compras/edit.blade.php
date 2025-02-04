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
                        <h3 class="panel-title">Editar Compra</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-container">
                            <form method="POST" action="{{ route('compras.update', $compra->id_com) }}" role="form">
                                @csrf
                                @method('PUT')

                                <!-- Datos de la Compra -->
                                <h4>Datos de la Compra</h4>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <input type="text" name="compra[id_com]" id="id_com"
                                                class="form-control input-sm" value="{{ $compra->id_com }}" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <select name="compra[ruc_pro]" id="nombre_proveedor_com"
                                                class="form-control input-sm" required onchange="updateRuc()">
                                                <option value="" disabled>Seleccione un Proveedor</option>
                                                @foreach ($proveedores as $proveedor)
                                                    <option value="{{ $proveedor->ruc_pro }}"
                                                        data-ruc="{{ $proveedor->ruc_pro }}"
                                                        @if ($compra->ruc_pro == $proveedor->ruc_pro) selected @endif>
                                                        {{ $proveedor->nombre_pro }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <input type="text" id="ruc_pro" class="form-control input-sm"
                                                placeholder="RUC Proveedor" value="{{ $compra->ruc_pro }}" readonly
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <input type="date" name="compra[fecha_emision_com]" id="fecha_emision_com"
                                                class="form-control input-sm" value="{{ $compra->fecha_emision_com }}"
                                                readonly required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detalles de la Compra -->
                                <h4>Detalles de la Compra</h4>
                                <div id="detalles-container">
                                    @foreach ($compra->detalles as $index => $detalle)
                                        <div class="detalle-item">
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <div class="form-group">
                                                        <input type="text"
                                                            name="detalles[{{ $index }}][id_detcom]"
                                                            class="form-control input-sm" value="{{ $detalle->id_detcom }}"
                                                            required readonly>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6">
                                                    <div class="form-group">
                                                        <input type="text"
                                                            name="detalles[{{ $index }}][codigo_pro]"
                                                            id="codigo_pro" class="form-control input-sm"
                                                            value="{{ $detalle->codigo_pro }}" readonly required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <div class="form-group">
                                                        <input type="number"
                                                            name="detalles[{{ $index }}][cantidad_pro_detcom]"
                                                            class="form-control input-sm"
                                                            value="{{ $detalle->cantidad_pro_detcom }}"
                                                            placeholder="Cantidad" required>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6">
                                                    <div class="form-group">
                                                        <input type="number"
                                                            name="detalles[{{ $index }}][iva_detcom]"
                                                            class="form-control input-sm"
                                                            value="{{ $detalle->iva_detcom }}" placeholder="IVA (%)"
                                                            step="0.01" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <div class="form-group">
                                                        <input type="number"
                                                            name="detalles[{{ $index }}][precio_unitario_com]"
                                                            class="form-control input-sm"
                                                            value="{{ $detalle->precio_unitario_com }}"
                                                            placeholder="Precio Unitario" step="0.01" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Botones -->
                                <div class="row mt-4">
                                    <div class="col-xs-12">
                                        <input type="submit" value="Actualizar" class="btn btn-success btn-block">
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
        function updateRuc() {
            let select = document.getElementById('nombre_proveedor_com');
            let rucField = document.getElementById('ruc_pro');
            let selectedOption = select.options[select.selectedIndex];

            if (selectedOption) {
                rucField.value = selectedOption.getAttribute('data-ruc');
            }
        }

        document.getElementById('fecha_emision_com').value = new Date().toISOString().split('T')[0];
    </script>
@endsection

@endsection
