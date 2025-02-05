<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Paws Word') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap y FontAwesome -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Scripts de Laravel -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .navbar-custom {
            background: rgb(8, 164, 92);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 24px;
            min-height: 60px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar-left {
            display: flex;
            align-items: center;
        }

        .navbar-brand {
            color: white !important;
            font-size: 24px;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            position: relative;
        }

        .user-menu {
            position: absolute;
            top: 50px;
            right: 0;
            background: white;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: none;
            min-width: 180px;
            z-index: 1000;
        }

        .user-menu a, .user-menu button {
            display: block;
            width: 100%;
            text-align: left;
            padding: 10px;
            background: none;
            border: none;
            cursor: pointer;
            text-decoration: none;
            color: black;
        }

        .user-menu a:hover, .user-menu button:hover {
            background: #f8f9fa;
        }

        .user-dropdown {
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .user-dropdown i {
            margin-left: 8px;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Barra de navegación personalizada -->
        <nav class="navbar-custom">
            <div class="navbar-left">
                <a class="navbar-brand" href="{{ route('menu') }}"><i class="fas fa-paw"></i> Paws Word</a>
            </div>
            <div class="navbar-right">
                <div class="user-dropdown" id="userDropdown">
                    <span>{{ Auth::user()->name ?? 'Invitado' }}</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="user-menu" id="userMenu">
                    <a href="javascript:history.back();"><i class="fas fa-arrow-left"></i> Volver</a>
                    <a href="{{ route('profile.edit') }}"><i class="fas fa-user"></i> Perfil</a>
                    <hr>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Contenido Principal -->
        <main class="py-6 px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>
    </div>

    <script>
        $(document).ready(function() {
            $('#userDropdown').on('click', function(event) {
                event.stopPropagation();
                $('#userMenu').toggle();
            });

            $(document).on('click', function(event) {
                if (!$(event.target).closest('.user-dropdown').length) {
                    $('#userMenu').hide();
                }
            });
        });
    </script>
</body>
</html>