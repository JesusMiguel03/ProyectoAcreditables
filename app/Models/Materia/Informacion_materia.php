<?php

namespace App\Models\Materia;

use App\Models\Academico\Horario;
use App\Models\Academico\Profesor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Informacion_materia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'informacion_materia';

    protected $fillable = [
        'metodologia',
        'horario_id',
        'categoria_id',
        'profesor_id'
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'id', 'informacion_id');
    }

    public function categoria()
    {
        return $this->hasOne(Categoria::class, 'id', 'categoria_id');
    }

    public function profesor()
    {
        return $this->hasOne(Profesor::class,  'id', 'profesor_id');
    }

    public function horario()
    {
        return $this->hasOne(Horario::class,  'id', 'horario_id');
    }
}
