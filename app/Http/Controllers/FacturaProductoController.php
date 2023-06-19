<?php

namespace App\Http\Controllers;

use App\Models\FacturaProducto;
use App\Models\Producto;
use Illuminate\Http\Request;

class FacturaProductoController extends Controller
{
    public function getFacturaDetail(Request $request){
        $detailFactura = FacturaProducto::select(
            'factura_producto.id_producto AS producto_id',
            'producto.nombre AS producto_nombre',
            'producto.precio AS producto_precio',
            'factura_producto.cantidad'
        )
        ->where('num_factura', $request->numFactura)
        ->join('producto', 'producto.id_producto', '=', 'factura_producto.id_producto')
        ->get();

        return [
            'num_factura' => $request->numFactura,
            'items' => $detailFactura
        ];
    }

    public function deleteFacturaDetail(Request $request){

        $itemAdded = FacturaProducto::where('id_producto', $request->idProducto)
        ->where('num_factura', $request->numFactura)
        ->first();

        FacturaProducto::where('num_factura', $request->numFactura)
        ->where('id_producto', $request->idProducto)
        ->delete();

        Producto::where('id_producto', $request->idProducto)
        ->increment('stock', $itemAdded->cantidad);

        return 'success';
    }
}
