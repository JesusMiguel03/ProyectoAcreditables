<?php

namespace App\Models\Materia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horario';

    protected $fillable = [
        'descripcion', 'start', 'end', 'aula', 'espacio', 'materia_id'
    ];

    public function info()
    {
        return $this->belongsTo(Informacion_curso::class, 'horario_id');
    }
}
