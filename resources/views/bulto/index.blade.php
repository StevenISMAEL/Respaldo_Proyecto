@extends('plantilla.plantilla')

@section('content')
<div class="row">
  <section class="content">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="pull-left"><h3>Lista de Bultos - Jostin Quilca</h3></div>
          <div class="pull-right">
            <div class="btn-group">
              <a href="{{ route('bulto.create') }}" class="btn btn-info">Añadir Bulto</a>
            </div>
          </div>
          <div class="table-container">
            <table class="table table-bordered table-striped">
              <thead>
                <th>Código</th>
                <th>Tipo de Animal</th>
                <th>Peso (lb)</th>
                <th>Precio por Libra</th>
                <th>Acciones</th>
              </thead>
              <tbody>
                @foreach($bultos as $bulto)
                <tr>
                  <td>{{ $bulto->codigo }}</td>
                  <td>{{ $bulto->tipo_animal }}</td>
                  <td>{{ $bulto->peso_lb }}</td>
                  <td>{{ $bulto->precio_por_libra }}</td>
                  <td>
                    <a href="{{ route('bulto.edit', $bulto->codigo) }}" class="btn btn-primary btn-xs">Editar</a>
                    <form action="{{ route('bulto.destroy', $bulto->codigo) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-xs">Eliminar</button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        {{ $bultos->links() }}
      </div>
    </div>
  </section>
@endsection
