<?php

namespace App\Models\Informacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pregunta_frecuente extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'preguntas_frecuentes';

    protected $fillable = ['titulo', 'explicacion'];
}
