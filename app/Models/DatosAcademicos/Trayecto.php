<?php

namespace App\Models\DatosAcademicos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trayecto extends Model
{
    use HasFactory;

    public $table = 'trayecto';

    protected $fillable = ['num_trayecto'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'trayecto_id');
    }
}
