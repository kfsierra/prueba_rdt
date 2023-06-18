<?php

namespace Database\Seeders;

use App\Models\CategoriaCliente;
use Illuminate\Database\Seeder;

class CategoriaClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoriaCliente::create([
            'id_categoria_cliente' => 1,
            'categoria' => 'VIP'
        ]);

        CategoriaCliente::create([
            'id_categoria_cliente' => 2,
            'categoria' => 'Regular'
        ]);
    }
}
