<?php

namespace Database\Seeders;

use App\Models\FacturaProducto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacturaProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FacturaProducto::create([
            'num_factura' => 1,
            'id_producto' => 1,
            'cantidad' => 2
        ]);

        FacturaProducto::create([
            'num_factura' => 1,
            'id_producto' => 2,
            'cantidad' => 1
        ]);

        FacturaProducto::create([
            'num_factura' => 2,
            'id_producto' => 3,
            'cantidad' => 4
        ]);

        FacturaProducto::create([
            'num_factura' => 2,
            'id_producto' => 4,
            'cantidad' => 15
        ]);
    }
}
