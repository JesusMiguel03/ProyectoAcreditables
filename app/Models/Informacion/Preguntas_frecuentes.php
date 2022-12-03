<?php

namespace App\Models\Informacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preguntas_frecuentes extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'explicacion'];
}
