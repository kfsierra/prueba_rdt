<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Producto::create([
            'nombre' => 'Computador HP La456773',
            'precio' => 73633,
            'stock' => 16
        ]);

        Producto::create([
            'nombre' => 'Computador Aser H167',
            'precio' => 46754,
            'stock' => 21
        ]);

        Producto::create([
            'nombre' => 'Memoria RAM 16GB',
            'precio' => 6854,
            'stock' => 167
        ]);

        Producto::create([
            'nombre' => 'Disco sólido 256GB',
            'precio' => 5488,
            'stock' => 105
        ]);
    }
}
