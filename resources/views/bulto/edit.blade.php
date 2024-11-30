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
                        <h3 class="panel-title">Editar Bulto</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-container">
                            <form method="POST" action="{{ route('bulto.update', $bulto->codigo) }}" role="form">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="codigo">Código</label>
                                    <input type="text" name="codigo" id="codigo" class="form-control"
                                        value="{{ $bulto->codigo }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="tipo_animal">Tipo de Animal</label>
                                    <input type="text" name="tipo_animal" id="tipo_animal" class="form-control"
                                        value="{{ $bulto->tipo_animal }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="tamano_raza">Tamaño/Raza</label>
                                    <select type="text" name="tamano_raza" id="tamano_raza" class="form-control"
                                        value="{{ $bulto->tamano_raza }}">
                                        <option value="Pequeño">Pequeño</option>
                                        <option value="Mediano">Mediano</option>
                                        <option value="Grande">Grande</option>
                                        <option value="N/D">N/D</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="peso_lb">Peso (en libras)</label>
                                    <input type="number" name="peso_lb" id="peso_lb" class="form-control"
                                        value="{{ $bulto->peso_lb }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="precio_por_libra">Precio por Libra</label>
                                    <input type="number" step="0.01" name="precio_por_libra" id="precio_por_libra"
                                        class="form-control" value="{{ $bulto->precio_por_libra }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="stock_minimo_bultos">Stock Mínimo</label>
                                    <input type="number" name="stock_minimo_bultos" id="stock_minimo_bultos"
                                        class="form-control" value="{{ $bulto->stock_minimo_bultos }}" required>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input type="submit" value="Actualizar" class="btn btn-success btn-block">
                                        <a href="{{ route('bulto.index') }}" class="btn btn-info btn-block">Atrás</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
