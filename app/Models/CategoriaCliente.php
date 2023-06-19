<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaCliente extends Model
{
    public $timestamps = false;
    protected $table = 'categoria_cliente';
    protected $primaryKey = 'id_categoria_cliente';

    protected $fillable = [
        'id_categoria_cliente',
        'categoria'
    ];
}
