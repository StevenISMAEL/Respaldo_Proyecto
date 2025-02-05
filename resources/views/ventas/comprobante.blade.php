<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Venta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .container {
            width: 100%;
            padding: 20px;
        }

        .header {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }

        .info {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            text-align: right;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">Comprobante de Venta</div>

        <div class="info">
            <p><strong>ID Venta:</strong> {{ $venta->id_ven }}</p>
            <p><strong>Fecha de Emisión:</strong> {{ $venta->fecha_emision_ven }}</p>
            <p><strong>Cliente:</strong> {{ $venta->cliente->nombre_cli ?? 'Sin nombre' }}</p>
            <p><strong>Cédula Cliente:</strong> {{ $venta->cliente->cedula_cli ?? 'N/A' }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>IVA</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($venta->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->producto->nombre_pro ?? 'Producto eliminado' }}</td>
                        <td>{{ $detalle->cantidad_pro_detven }}</td>
                        <td>${{ number_format($detalle->precio_unitario_detven, 2) }}</td>
                        <td>{{ $detalle->iva_detven }}%</td>
                        <td>${{ number_format($detalle->subtotal_detven, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="total">Total de la Venta: ${{ number_format($venta->total_ven, 2) }}</p>
    </div>
</body>

</html>
