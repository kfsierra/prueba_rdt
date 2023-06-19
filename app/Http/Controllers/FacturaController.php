<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\FacturaProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{

    public function getAll()
    {
        $facturas = Factura::select(
            'factura.num_factura',
            'cliente.cedula AS cliente_cedula',
            DB::raw("CONCAT(cliente.nombre, ' ', cliente.apellido) AS cliente_nombre"),
            'factura.created_at AS fecha'
        )
        ->join('cliente', 'cliente.id_cliente', '=', 'factura.id_cliente')
        ->orderBy('factura.num_factura', 'asc')
        ->get();

        return $facturas;
    }

}
