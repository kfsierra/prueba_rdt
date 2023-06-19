<table>
    <thead>
        <tr>
            <td>NUM FACTURA</td>
            <td>CÉDULA</td>
            <td>CLIENTE</td>
            <td>FECHA</td>
        </tr>
    </thead>
    <tbody>
        @foreach($facturas as $factura)
            <tr>
                <td>{{ $factura->num_factura }}</td>
                <td>{{ $factura->cedula }}</td>
                <td>{{ $factura->cliente }}</td>
                <td>{{ $factura->fecha }}</td>
                <td></td>
            </tr>

            @if (count($factura->detalle))
                <tr>
                    <td colspan="5"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>ID PRODUCTO</td>
                    <td>NOMBRE PRODUCTO</td>
                    <td>PRECIO</td>
                    <td>CANTIDAD</td>
                </tr>
            @endif

            @foreach ($factura->detalle as $detalle)
                <tr>
                    <td></td>
                    <td>{{ $detalle->id_producto }}</td>
                    <td>{{ $detalle->producto_nombre }}</td>
                    <td>${{ $detalle->precio }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                </tr>
            @endforeach

            @if (count($factura->detalle))
                <tr rowspan="2">
                    <td colspan="5"></td>
                </tr>
            @endif

        @endforeach
    </tbody>
</table>
