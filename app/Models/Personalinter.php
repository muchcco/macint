<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personalinter extends Model
{
    use HasFactory;

    protected $table = 'personal_inter';

    protected $fillable = [ 'id', 'id_persona', 'validez', 'observacion', 'estado', 'fec_entrega', 'fec_devol', 'entidad'];
}
