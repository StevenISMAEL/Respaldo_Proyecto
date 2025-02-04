@extends('plantilla.plantilla')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="panel-card" style="background-color: #f0ad4e;">
                    <h3><i class="glyphicon glyphicon-user"></i> Total Usuarios</h3>
                    <p style="font-size: 24px;">{{ $usuarios->count() }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel-card" style="background-color: #5bc0de;">
                    <h3><i class="glyphicon glyphicon-king"></i> Administradores</h3>
                    <p style="font-size: 24px;">{{ $usuarios->filter(fn($user) => $user->hasRole('admin'))->count() }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel-card" style="background-color: #5cb85c;">
                    <h3><i class="glyphicon glyphicon-tasks"></i> Roles Totales</h3>
                    <p style="font-size: 24px;">{{ $roles->count() }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel-card" style="background-color: #d9534f;">
                    <h3><i class="glyphicon glyphicon-lock"></i> Permisos Totales</h3>
                    <p style="font-size: 24px;">{{ $permisos->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Sección de usuarios -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="pull-left">
                            <h3>Gestión de Usuarios</h3>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('roles.create') }}" class="btn btn-info">Añadir Usuario</a>
                        </div>

                        <div class="table-container">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Rol</th>
                                    <th>Permisos</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($usuarios as $usuario)
                                        <tr>
                                            <td>{{ $usuario->id }}</td>
                                            <td>{{ $usuario->name }}</td>
                                            <td>{{ $usuario->email }}</td>
                                            <td>{{ implode(', ', $usuario->roles->pluck('name')->toArray()) }}</td>
                                            <td>{{ implode(', ', $usuario->getAllPermissions()->pluck('name')->toArray()) }}</td>
                                            <td>
                                                <a href="{{ route('roles.edit', $usuario->id) }}"
                                                   class="btn btn-warning btn-sm">
                                                    <i class="glyphicon glyphicon-pencil"></i> Editar
                                                </a>
                                                <form action="{{ route('roles.destroy', $usuario->id) }}"
                                                      method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('¿Está seguro de eliminar este usuario?');">
                                                        <i class="glyphicon glyphicon-trash"></i> Eliminar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $usuarios->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
