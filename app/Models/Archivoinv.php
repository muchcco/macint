<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivoinv extends Model
{
    use HasFactory;

    protected $table = 'archivo_inv';

    protected $fillable = [ 'id', 
                            'id_persona', 
                            'ruta', 
                            'nom_archivo', 
                            'corr_archivo'
                        ];

    // public $timestamps = false;
}
