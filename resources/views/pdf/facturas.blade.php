<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Facturas PDF</title>

    <style type="text/css">

        table {
            width: 100%;
            text-align: center;
        }

        table thead td {
            width: 25%;
            background-color: rgb(134 239 172);
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table th, td {
            padding-top: 5px;
            padding-bottom: 5px;
        }

    </style>

</head>
<body>

    <table>
        <thead>
            <tr>
                <th>Num factura</th>
                <th>Cédula</th>
                <th>Cliente</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($facturas as $factura)
                <tr>
                    <td style="color: rgb(13 148 136)">{{ $factura->num_factura }}</td>
                    <td style="color: rgb(13 148 136)">{{ $factura->cedula }}</td>
                    <td style="color: rgb(13 148 136)">{{ $factura->cliente }}</td>
                    <td style="color: rgb(13 148 136)">{{ $factura->fecha }}</td>
                </tr>
                @if (count($factura->detalle))
                    <tr>
                        <td colspan="4">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Id producto</th>
                                        <th>Nombre producto</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($factura->detalle as $detalle)
                                        <tr>
                                            <td>{{ $detalle->id_producto }}</td>
                                            <td>{{ $detalle->producto_nombre }}</td>
                                            <td>${{ $detalle->precio }}</td>
                                            <td>{{ $detalle->cantidad }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endif
            @endforeach

        </tbody>
    </table>

</body>
</html>
