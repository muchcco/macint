<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $table = 'personal';

    protected $fillable = [ 'id', 'nombre', 'ap_pat', 'ap_mat', 'dni', 'correo','entidad', 'sexo'. 'telefono', 'flag', 'fech_nac'];

    public $timestamps = false;
}
