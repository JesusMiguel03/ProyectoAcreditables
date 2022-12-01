<?php

namespace App\Models\Materia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    public $fillable = [
        'Sem1', 'Sem2', 'Sem3', 'Sem4', 'Sem5', 'Sem6', 'Sem7', 'Sem8', 'Sem9', 'Sem10', 'Sem11', 'Sem12', 
    ];
}
