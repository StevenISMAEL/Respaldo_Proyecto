@extends('plantilla.plantilla')

@section('content')
<div class="row">
    <section class="content">
        <div class="col-md-8 col-md-offset-2">
            <form method="POST" action="{{ route('venta.update', $venta->id) }}">
                @csrf
                @method('PUT')

                <!-- Código de venta (solo lectura) -->
                <div class="form-group">
                    <label for="codigo">Código de Venta</label>
                    <input type="text" name="codigo" id="codigo" class="form-control" value="venta{{ str_pad($venta->id, 3, '0', STR_PAD_LEFT) }}" readonly>
                </div>

                <!-- Total -->
                <div class="form-group">
                    <label for="total">Total</label>
                    <input type="number" step="0.01" name="total" class="form-control" value="{{ old('total', $venta->total) }}" required>
                </div>

                <!-- Estado de Venta -->
                <div class="form-group">
                    <label for="estado_venta">Estado de Venta</label>
                    <select name="estado_venta" class="form-control" required>
                        <option value="Pendiente" {{ $venta->estado_venta == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="Pagado" {{ $venta->estado_venta == 'Pagado' ? 'selected' : '' }}>Pagado</option>
                        <option value="Cancelado" {{ $venta->estado_venta == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>

                <!-- Método de Pago -->
                <div class="form-group">
                    <label for="metodo_pago">Método de Pago</label>
                    <select name="metodo_pago" class="form-control" required>
                        <option value="Transferencia" {{ $venta->metodo_pago == 'Transferencia' ? 'selected' : '' }}>Transferencia</option>
                        <option value="Efectivo" {{ $venta->metodo_pago == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Actualizar</button>
                    <a href="{{ route('venta.index') }}" class="btn btn-info">Atrás</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
