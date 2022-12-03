<?php

namespace App\Models\Profesor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    use HasFactory;

    public $table = 'especialidad';

    protected $fillable = ['nom_especialidad', 'desc_especialidad'];

    public function profesores()
    {
        return $this->hasMany(Profesor::class);
    }
}
