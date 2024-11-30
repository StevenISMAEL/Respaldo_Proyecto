@extends('plantilla.plantilla')

@section('content')
<div class="row">
    <section class="content">
        <div class="col-md-8 col-md-offset-2">
            <form method="POST" action="{{ route('bulto.store') }}">
                @csrf

                <div class="form-group">
                    <label for="tipo_animal">Tipo de Animal</label>
                    <select type="text" name="tipo_animal" id="tipo_animal" class="form-control" required>
                        <option value="Perro">Perro</option>
                        <option value="Perro">Gato</option>
                        <option value="Perro">Otro..</option>
                    </select>
                </div>

                <div class="form-group">
                  <label for="tamano_raza">Tamaño/Raza</label>
                  <select name="tamano_raza" id="tamano_raza" class="form-control">
                      <option value="Pequeño">Pequeño</option>
                      <option value="Mediano">Mediano</option>
                      <option value="Grande">Grande</option>
                      <option value="N/D">N/D</option>
                  </select>
              </div>

                <div class="form-group">
                    <label for="peso_lb">Peso (en libras)</label>
                    <input type="number" name="peso_lb" id="peso_lb" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="precio_por_libra">Precio por Libra</label>
                    <input type="number" step="0.01" name="precio_por_libra" id="precio_por_libra" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="stock_minimo_bultos">Stock Mínimo</label>
                    <input type="number" name="stock_minimo_bultos" id="stock_minimo_bultos" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="{{ route('bulto.index') }}" class="btn btn-info">Atrás</a>
            </form>
        </div>
    </section>
@endsection
