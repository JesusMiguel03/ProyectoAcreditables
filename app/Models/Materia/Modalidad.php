<?php

namespace App\Models\Materia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modalidad extends Model
{
    use HasFactory;

    public $table = 'modalidades';

    public function info()
    {
        return $this->belongsTo(Informacion_curso::class, 'modalidad_id');
    }
}
