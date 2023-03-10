<?php

namespace App\Models\Academico;

use App\Models\Materia\Informacion_materia;
use App\Models\Materia\Materia;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profesor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'profesores';

    protected $fillable = [
        'usuario_id',
        'conocimiento_id',
        'departamento_id',
        'telefono',
        'casa',
        'calle',
        'urb',
        'ciudad',
        'estado',
        'fecha_de_nacimiento',
        'fecha_ingreso_institucion',
        'activo'
    ];

    /**
     *  Funciones personalizadas
     */
    public function avatar()
    {
        return $this->usuario->avatar ?? null;
    }

    public function nombreProfesor()
    {
        return $this->usuario->nombreCompleto();
    }

    public function profesorCI()
    {
        $nacionalidad = $this->usuario->nacionalidad;
        $cedula = number_format($this->usuario->cedula, 0, '', '.');
        return "{$nacionalidad}-{$cedula}";
    }

    /**
     *  Relaciones
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }

    public function conocimiento()
    {
        return $this->belongsTo(AreaConocimiento::class, 'conocimiento_id', 'id');
    }

    public function departamento()
    {
        return $this->belongsTo(Pnf::class, 'departamento_id', 'id');
    }

    public function materias()
    {
        $materias = Informacion_materia::where('profesor_id', '=', $this->id)->get();
        return $materias;
    }

    public function imparteMateria()
    {
        return $this->hasMany(Informacion_materia::class, 'profesor_id', 'id');
    }

    public function scopeCreadoEntre($query, array $fechas)
    {
        $inicio = ($fechas[0] instanceof Carbon) ? $fechas[0] : Carbon::parse($fechas[0])->startOfDay();
        $fin = ($fechas[1] instanceof Carbon) ? $fechas[1] : Carbon::parse($fechas[1])->endOfDay();

        return $query->whereBetween('created_at', [$inicio, $fin]);
    }
}
