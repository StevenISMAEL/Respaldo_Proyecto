@extends('plantilla.plantilla')

@section('content')
<div class="row">
  <section class="content">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="pull-left"><h3>Lista de Proveedores </h3></div>
          <div class="pull-right">
            <div class="btn-group">
              <a href="{{ route('proveedor.create') }}" class="btn btn-info" >Añadir Proveedor</a>
            </div>
          </div>
          <div class="table-container">
            <table class="table table-bordered table-striped">
              <thead>
                <th>RUC</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Activo</th>
                <th>Acciones</th>
              </thead>
              <tbody>
                @if($proveedores->count())  
                @foreach($proveedores as $proveedor)  
                <tr>
                  <td>{{$proveedor->ruc}}</td>
                  <td>{{$proveedor->nombre}}</td>
                  <td>{{$proveedor->correo}}</td>
                  <td>{{$proveedor->telefono}}</td>
                  <td>{{$proveedor->direccion}}</td>
                  <td>{{ $proveedor->activo ? 'Sí' : 'No' }}</td>
                  <td>
                    <a href="{{ route('proveedor.edit', $proveedor->ruc) }}" class="btn btn-primary btn-xs">Editar</a>
                    <form action="{{ route('proveedor.destroy', $proveedor->ruc) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-xs">Eliminar</button>
                    </form>
                  </td>
                </tr>
                @endforeach
                @else
                <tr>
                 <td colspan="8">No hay registros disponibles.</td>
               </tr>
               @endif
              </tbody>
            </table>
          </div>
        </div>
        {{ $proveedores->links() }}
      </div>
    </div>
  </section>
@endsection
