<?php

namespace App\Models\Materia;

use App\Models\Profesor\Profesor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informacion_materia extends Model
{
    use HasFactory;

    protected $table = 'informacion_materia';

    protected $fillable = [
        'metodologia_aprendizaje',
        'horario_id',
        'categoria_id',
        'profesor_id'
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'informacion_id');
    }

    public function categoria()
    {
        return $this->hasOne(Categoria::class, 'id');
    }

    public function horario()
    {
        return $this->hasOne(Horario::class,  'id');
    }

    public function profesor()
    {
        return $this->hasOne(Profesor::class,  'id');
    }
}
