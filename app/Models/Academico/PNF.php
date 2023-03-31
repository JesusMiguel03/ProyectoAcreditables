<?php

namespace App\Models\Academico;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PNF extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pnfs';

    protected $fillable = ['nom_pnf', 'cod_pnf', 'trayectos'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'pnf_id');
    }

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'pnf_id');
    }

    public function profesores()
    {
        return $this->hasMany(Profesor::class, 'departamento_id');
    }

    public function scopeCreadoEntre($query, array $fechas)
    {
        $inicio = ($fechas[0] instanceof Carbon) ? $fechas[0] : Carbon::parse($fechas[0])->startOfDay();
        $fin = ($fechas[1] instanceof Carbon) ? $fechas[1] : Carbon::parse($fechas[1])->endOfDay();

        return $this->estudiantes()->whereBetween('created_at', [$inicio, $fin]);
    }
}
