<?php

namespace App\Models\Materia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asistencia extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "asistencias";

    public $fillable = [
        'sem1', 'sem2', 'sem3', 'sem4', 'sem5', 'sem6', 'sem7', 'sem8', 'sem9', 'sem10', 'sem11', 'sem12', 
    ];
}
