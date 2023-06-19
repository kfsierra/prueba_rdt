<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Factura;
use App\Models\FacturaProducto;
use App\Models\Producto;
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

    public function getNecessaryDataToCreate()
    {

        $clientes = Cliente::select(
            'id_cliente',
            'cedula',
            DB::raw("CONCAT(nombre, ' ', apellido) AS cliente_nombre")
        )->get();

        $productos = Producto::all();

        return [
            'clientes' => $clientes,
            'productos' => $productos
        ];
    }

    public function store(Request $request)
    {

        $items = json_decode(json_encode($request->items));

        DB::beginTransaction();
        try {

            $factura = new Factura;
            $factura->id_cliente = $request->idCliente;
            $factura->save();

            foreach ($items as $item) {

                FacturaProducto::create([
                    'num_factura' => $factura->num_factura,
                    'id_producto' => $item->id,
                    'cantidad' => $item->cantidad
                ]);

                $productoUpdate = Producto::where('id_producto', $item->id)->first();
                $productoUpdate->stock -= $item->cantidad;
                $productoUpdate->save();

            }

            $cliente = Cliente::where('id_cliente', $factura->id_cliente)->first();

            $status = [
                'error' => false,
                'message' => '',
                'facturaCreated' => [
                    'num_factura' => $factura->num_factura,
                    'cliente_cedula' => $cliente->cedula,
                    'cliente_nombre' => $cliente->nombre,
                    'fecha' => $factura->created_at
                ]
            ];

            DB::commit();

        } catch (\Throwable $th) {

            $status = [
                'error' => true,
                'message' => 'Surgió un error inesperado al crear la factura: ' . $th->getMessage()
            ];

            DB::rollback();
        }

        return $status;
    }

    public function destroy(Request $request)
    {
        FacturaProducto::where('num_factura', $request->numFactura)
        ->delete();
        Factura::where('num_factura', $request->numFactura)
        ->delete();

        return 'OK';
    }

}
