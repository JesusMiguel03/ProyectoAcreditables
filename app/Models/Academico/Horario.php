<?php

namespace App\Models\Academico;

use App\Models\Materia\Materia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Horario extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['materia_id', 'espacio', 'edificio', 'dia', 'hora', 'campo'];

    public function materia()
    {
        return $this->hasOne(Materia::class, 'id', 'materia_id');
    }
}
