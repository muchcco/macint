<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventario';

    protected $fillable = [ 'id', 
                            'id_almacen', 
                            'id_personal', 
                            'fecha_entrega', 
                            'flag', 
                            'fecha_devol', 
                            'validez_per',
                            'fecha_validez',
                            'observacion'
                        ];

    // public $timestamps = false;
}
