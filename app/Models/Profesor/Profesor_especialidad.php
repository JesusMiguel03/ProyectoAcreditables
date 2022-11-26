<?php

namespace App\Models\Profesor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor_especialidad extends Model
{
    use HasFactory;

    public $table = 'profesor_especialidad';

    protected $fillable = [
        'especialidad_id', 'usuario_id'
    ];
}
