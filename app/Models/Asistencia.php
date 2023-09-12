<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $table = 'asistencia';

    protected $fillable = [ 'id', 'dni', 'id_mac', 'fecha', 'hora', 'fecha_biometrico', 'status', 'tipo_entidad', 'corr_dia', 'año', 'mes'];

    public $timestamps = false;
}
