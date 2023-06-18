<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaProducto extends Model
{
    public $timestamps = false;
    protected $table = 'factura_producto';

    protected $fillable = [
        'id_factura',
        'id_producto',
        'cantidad'
    ];
}
