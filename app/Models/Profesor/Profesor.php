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
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function especialidad()
    {
        return $this->belongsToMany(Especialidad::class, 'profesor_especialidad', 'usuario_id');
    }
}
