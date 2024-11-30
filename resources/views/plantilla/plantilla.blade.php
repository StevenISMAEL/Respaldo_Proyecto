<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <style>
        .container1 {
            margin-top: 50px;
            padding: 20px;
            background-color: #f7f7f7;
            position: relative;
            text-align: center;
        }

        .container1 h1 {
            font-size: 2em;
            color: #333;
        }

        #h1titulo {
            font-size: 36px;
            color: #333;
            font-weight: bold;
            text-align: center;

        }
    </style>
</head>

<body>
    <div class="container1">
        <h1 id="h1titulo">Examen grupal 1 mipymes</h1>
        <h3>Fecha: 30 de noviembre del 2024</h3>
        <a href="{{ route('menu') }}" class="btn btn-primary btn-lg">Ir al Menú</a>
    </div>
    <div class="container-fluid" style="margin-top: 100px">

        @yield('content')
    </div>
    <style type="text/css">
        .table {
            border-top: 2px solid #ccc;
        }
    </style>


</body>

</html>
