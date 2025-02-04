<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: rgba(34, 45, 50, 255);
            color: #fff;
            transition: all 0.3s;
            height: 100vh;
            position: fixed;
        }

        #sidebar.collapsed {
            margin-left: -250px;
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: rgb(8, 132, 76);
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        #sidebar ul.components {
            padding: 20px 0;
        }

        #sidebar ul li a {
            padding: 10px;
            font-size: 1.1em;
            display: block;
            color: #fff;
            text-decoration: none;
        }

        #sidebar ul li a:hover {
            color: #218838;
            background: #fff;
        }

        #sidebar ul li.active a {
            color: #fff;
            background: rgb(8, 132, 76);
            font-weight: bold;
        }

        #content {
            margin-left: 250px;
            width: calc(100% - 250px);
            padding: 20px;
            min-height: 100vh;
            background: #f7f7f7;
            transition: all 0.3s;
        }

        #content.expanded {
            margin-left: 0;
            width: 100%;
        }

        .navbar {
            margin: 0;
            border-radius: 0;
            background: rgb(8, 164, 92);
            color: #fff;
        }

        .btn-info {
            background: rgba(34, 45, 50, 255);
            border: none;
        }

        .btn-info:hover {
            background: #3e423f;
        }

        .btn-logout {
            color: white !important;
        }

        .panel {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Barra lateral -->
        <nav id="sidebar">
            <div class="sidebar-header">
                Paws Word
            </div>
            <ul class="list-unstyled components">
                <li class="{{ Route::currentRouteNamed('menu') ? 'active' : '' }}">
                    <a href="{{ route('menu') }}">
                        <i class="glyphicon glyphicon-home"></i> Inicio
                    </a>
                </li>
                <li class="{{ Request::is('clientes*') ? 'active' : '' }}">
                    <a href="{{ route('clientes.index') }}">
                        <i class="glyphicon glyphicon-user"></i> Clientes
                    </a>
                </li>
                <li class="{{ Request::is('productos*') ? 'active' : '' }}">
                    <a href="{{ route('productos.index') }}">
                        <i class="glyphicon glyphicon-gift"></i> Productos
                    </a>
                </li>
                <li class="{{ Request::is('venta*') ? 'active' : '' }}">
                    <a href="{{ route('ventas.index') }}">
                        <i class="glyphicon glyphicon-shopping-cart"></i> Ventas
                    </a>
                </li>
                <li class="{{ Request::is('compras*') ? 'active' : '' }}">
                    <a href="{{ route('compras.index') }}">
                        <i class="glyphicon glyphicon-credit-card"></i> Compras
                    </a>
                </li>
                <li class="{{ Request::is('proveedor*') ? 'active' : '' }}">
                    <a href="{{ route('proveedor.index') }}">
                        <i class="glyphicon glyphicon-briefcase"></i> Proveedores
                    </a>
                </li>
                <li class="{{ Request::is('configuracion*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="glyphicon glyphicon-cog"></i> Configuración
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Contenido principal -->
        <div id="content">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                        <i class="glyphicon glyphicon-align-left"></i>
                    </button>
                    {{-- <div class="navbar-header">
                        <a class="navbar-brand" style="color:#fff" href="#">Paws Word</a>
                    </div> --}}
                    <ul class="nav navbar-nav navbar-right">
                        <li class="navbar-text" style="color:#fff">
                            <strong>Usuario actual:</strong> {{ Auth::user()->name ?? 'Invitado' }}
                        </li>
                        <li class="ml-3">
                            <form method="POST" action="{{ route('logout') }}" style="display:inline; padding: 10px">
                                @csrf
                                <button class="btn btn-danger navbar-btn btn-logout" type="submit">Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            @yield('content')
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('collapsed');
                $('#content').toggleClass('expanded');
            });
        });
    </script>
</body>
@yield('scripts')

</html>
