<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
    use HasFactory;

    protected $table = 'entidad';

    protected $fillable = [ 'id', 'nombre', 'nombre_abrv'];

    public $timestamps = false;
}
