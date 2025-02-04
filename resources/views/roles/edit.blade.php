@extends('plantilla.plantilla')

@section('content')
    <div class="row">
        <section class="content">
            <div class="col-md-8 col-md-offset-2">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Error!</strong> Revise los campos obligatorios.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Editar Usuario</h3>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="{{ route('roles.update', $usuario->id) }}">
                            @csrf
                            @method('PATCH')

                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" name="name" id="name" class="form-control"
                                       value="{{ $usuario->name }}" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" name="email" id="email" class="form-control"
                                       value="{{ $usuario->email }}" required>
                            </div>

                            <div class="form-group">
                                <label for="roles">Roles</label>
                                <select name="roles[]" id="roles" class="form-control" multiple>
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol->id }}"
                                            {{ $usuario->roles->contains($rol) ? 'selected' : '' }}>
                                            {{ $rol->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="permisos">Permisos</label>
                                <select name="permisos[]" id="permisos" class="form-control" multiple>
                                    @foreach ($permisos as $permiso)
                                        <option value="{{ $permiso->id }}"
                                            {{ $usuario->hasPermissionTo($permiso) ? 'selected' : '' }}>
                                            {{ $permiso->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success btn-block">Actualizar</button>
                            <a href="{{ route('roles.index') }}" class="btn btn-info btn-block">Atrás</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
