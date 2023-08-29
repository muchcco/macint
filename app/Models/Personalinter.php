<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personalinter extends Model
{
    use HasFactory;

    protected $table = 'personal_inter';

    protected $fillable = [ 
                            'id', 
                            'id_persona', 
                            'validez', 
                            'observacion', 
                            'estado', 
                            'firma_tic',
                            'fec_firma_tic', 
                            'firma_cor',
                            'fec_firma_cor', 
                            'fec_entrega', 
                            'fec_devol'
                        ];
}
