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
                        <h3 class="panel-title">Editar Proveedor </h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-container">
                            <form method="POST" action="{{ route('proveedor.update', $proveedor->ruc_pro) }}"
                                role="form">
                                {{ csrf_field() }}
                                <input name="_method" type="hidden" value="PATCH">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="ruc_pro" id="ruc_pro"
                                                class="form-control input-sm" value="{{ $proveedor->ruc_pro }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="nombre_pro" id="nombre_pro"
                                                class="form-control input-sm" value="{{ $proveedor->nombre_pro }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="email" name="correo_pro" id="correo_pro" class="form-control input-sm"
                                        value="{{ $proveedor->correo_pro }}" placeholder="Correo electrónico">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="telefono_pro" id="telefono_pro"
                                        class="form-control input-sm" value="{{ $proveedor->telefono_pro }}"
                                        placeholder="Teléfono">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="direccion_pro" id="direccion_pro"
                                        class="form-control input-sm" value="{{ $proveedor->direccion_pro }}"
                                        placeholder="Dirección">
                                </div>
                                <div class="form-group">
                                    <label for="activo_pro">Activo</label>
                                    <select name="activo_pro" id="activo_pro" class="form-control">
                                        <option value="1" {{ $proveedor->activo_pro ? 'selected' : '' }}>Sí</option>
                                        <option value="0" {{ $proveedor->activo_pro ? '' : 'selected' }}>No</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="notas_pro" id="notas_pro" class="form-control input-sm"
                                        value="{{ $proveedor->notas_pro }}" placeholder="Notas del proveedor">
                                </div>
                                <div class="form-group">
                                    <label for="created_at">Fecha de Creación</label>
                                    <input type="text" name="created_at" id="created_at" class="form-control"
                                        value="{{ \Carbon\Carbon::parse($proveedor->created_at)->format('d-m-Y') }}"
                                        readonly>
                                </div>
                                <div class="form-group">
                                    <label for="updated_at">Última Fecha de Edición</label>
                                    <input type="text" name="updated_at" id="updated_at" class="form-control"
                                        value="{{ \Carbon\Carbon::parse($proveedor->updated_at)->format('d-m-Y') }}"
                                        readonly>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input type="submit" value="Actualizar" class="btn btn-success btn-block">
                                        <a href="{{ route('proveedor.index') }}" class="btn btn-info btn-block">Atrás</a>
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
