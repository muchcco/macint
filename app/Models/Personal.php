<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $table = 'personal';

    protected $fillable = [ 'id', 'nombre', 'ap_pat', 'ap_mat', 'dni', 'entidad', 'sexo'. 'telefono', 'flag'];

    public $timestamps = false;
}
