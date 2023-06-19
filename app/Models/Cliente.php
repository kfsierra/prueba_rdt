<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'id_cliente';

    protected $fillable = [
        'cedula',
        'nombre',
        'apellido',
        'direccion',
        'fecha_nacimiento',
        'telefono',
        'email',
        'id_categoria_cliente'
    ];
}
