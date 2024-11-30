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
                            <form method="POST" action="{{ route('producto.store') }}" role="form">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="codigo" id="codigo"
                                                class="form-control input-sm" placeholder="Código del producto" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="nombre" id="nombre"
                                                class="form-control input-sm" placeholder="Nombre del producto" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <textarea name="descripcion" class="form-control input-sm" placeholder="Descripción del producto"></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="tipo_producto" id="tipo_producto"
                                                class="form-control input-sm" placeholder="Tipo de producto" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="number" name="precio_unitario" id="precio_unitario"
                                                class="form-control input-sm" placeholder="Precio unitario" step="0.01"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <select name="estado" id="estado" class="form-control input-sm" required>
                                                <option value="Activo">Activo</option>
                                                <option value="Descontinuado">Descontinuado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="alumenticio">Producto Alimenticio?</label>
                                            <select name="alimenticio" id="alimenticio" class="form-control input-sm"
                                                required>
                                                <option value="1">Sí</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input type="submit" value="Guardar" class="btn btn-success btn-block">
                                        <a href="{{ route('producto.index') }}" class="btn btn-info btn-block">Atrás</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
