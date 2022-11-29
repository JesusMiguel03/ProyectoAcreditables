<?php

namespace App\Models\Profesor;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;

    public $table = 'profesores';

    protected $fillable = [
        'usuario_id',
        'titulo',
        'genero',
        'direccion',
        'ciudad',
        'estado',
        'telefono',
        'fecha_de_nacimiento',
        'fecha_ingreso_plantel',
        'estado_profesor'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }

    public function especialidades()
    {
        return $this->belongsToMany(Especialidad::class, 'profesor_especialidad', 'profesor_id', 'especialidad_id');
    }
}