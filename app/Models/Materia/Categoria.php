<?php

namespace App\Models\Materia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "categorias";

    protected $fillable = ["nom_categoria"];

    public function info()
    {
        return $this->belongsTo(Informacion_curso::class, 'categoria_id');
    }
}
