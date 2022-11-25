<?php

namespace App\Models\Materia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    public function info()
    {
        return $this->belongsTo(Informacion_curso::class, 'categoria_id');
    }
}
