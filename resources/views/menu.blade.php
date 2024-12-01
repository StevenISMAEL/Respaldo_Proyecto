@extends('plantilla.plantilla')

@section('content')
   


   {{--  <a href="{{ route('isla.index') }}" class="btn">CRUD ISLAS</a>
    <a href="{{ route('libro.index') }}" class="btn">CRUD LIBROS</a> --}}

    <div class="row">
        <section class="content">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="pull-left">
                            <h3>Integrantes del grupo</h3>
                        </div>
                        
                        <div class="table-container">
                            <table id="mytable" class="table table-bordred table-striped">
                                <thead>
                                    <th>Nombre del integrante</th>
                                    <th>CRUDs encargados</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            Arellano Montalvo Isai Leonel
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('cliente.index') }}" class="btn btn-info">CRUD Clientes</a>
                                            </div>
                                            <div class="btn-group">
                                                <a href="{{ route('producto.index') }}" class="btn btn-info">CRUD Productos</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Quilca Portilla Jostin Damian
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('bulto.index') }}" class="btn btn-info">CRUD Bultos</a>
                                            </div>
                                            <div class="btn-group">
                                                <a href="{{ route('venta.index') }}" class="btn btn-info">CRUD Ventas</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Lara Cruz Steven Ismael
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('proveedor.index') }}" class="btn btn-info">CRUD Proveedores</a>
                                            </div>
                                            <div class="btn-group">
                                                <a href="{{ route('inventario.index') }}" class="btn btn-info">CRUD Inventario</a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                   
                </div>
            </div>
        </section>
@endsection
