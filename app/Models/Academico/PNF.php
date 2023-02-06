<?php

namespace App\Models\Academico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PNF extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pnfs';

    protected $fillable = ['nom_pnf', 'cod_pnf'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'pnf_id');
    }

    public function profesores()
    {
        return $this->hasMany(Profesor::class, 'departamento_id');
    }
}
