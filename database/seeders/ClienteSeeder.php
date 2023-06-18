<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cliente::create([
            'cedula' => '11111111',
            'nombre' => 'Kevin Farid',
            'apellido' => 'Sierra Beltrán',
            'direccion' => 'Calle 1A #10-56 Piedecuesta',
            'fecha_nacimiento' => '2003-04-02',
            'telefono' => '4362743274',
            'email' => 'kevinfsierra43@gmail.com',
            'id_categoria_cliente' => 1
        ]);

        Cliente::create([
            'cedula' => '2222222',
            'nombre' => 'John',
            'apellido' => 'Doe',
            'direccion' => 'Calle 16 #20-19 Bucaramanga',
            'fecha_nacimiento' => '1992-06-15',
            'telefono' => '774737373',
            'email' => 'johndoe@gmail.com',
            'id_categoria_cliente' => 2
        ]);

        Cliente::create([
            'cedula' => '11111111',
            'nombre' => 'Lucía Cristina',
            'apellido' => 'Ramirez',
            'direccion' => 'Carrera 5 # 19-56 Floridablanca',
            'fecha_nacimiento' => '2000-11-12',
            'telefono' => '32424234234',
            'email' => 'lucyramirez@gmail.com',
            'id_categoria_cliente' => 1
        ]);
    }
}
