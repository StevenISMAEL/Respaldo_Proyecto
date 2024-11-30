@extends('plantilla.plantilla')

@section('content')
<div class="row">
    <section class="content">
        <div class="col-md-8 col-md-offset-2">
            <form method="POST" action="{{ route('venta.store') }}">
                @csrf

                <div class="form-group">
                    <label for="codigo">Código de Venta</label>
                    <input type="text" name="codigo" id="codigo" class="form-control" value="Generado después de guardar" readonly>
                </div>

                <div class="form-group">
                    <label for="total">Total</label>
                    <input type="number" step="0.01" name="total" class="form-control" value="{{ old('total') }}" required>
                </div>

                <div class="form-group">
                    <label for="estado_venta">Estado de Venta</label>
                    <select name="estado_venta" class="form-control" required>
                        <option value="Pendiente">Pendiente</option>
                        <option value="Pagado">Pagado</option>
                        <option value="Cancelado">Cancelado</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="metodo_pago">Método de Pago</label>
                    <select name="metodo_pago" class="form-control" required>
                        <option value="Transferencia">Transferencia</option>
                        <option value="Efectivo">Efectivo</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a href="{{ route('venta.index') }}" class="btn btn-info">Atrás</a>
                </div>
            </form>
        </div>
    </section>
@endsection
