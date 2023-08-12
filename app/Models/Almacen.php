<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;

    protected $table = 'almacen';

    protected $fillable = [ 'id', 
                            'cod_patrimonial', 
                            'cod_pronsace', 
                            'cod_intenro_pcm', 
                            'descripcion', 
                            'marca', 
                            'modelo', 
                            'modelo',
                            'color',
                            'serie_medida',
                            'estado',
                            'ubicacion'
                        ];

    public $timestamps = false;
}
