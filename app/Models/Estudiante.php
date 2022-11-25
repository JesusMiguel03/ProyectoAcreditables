<?php

namespace App\Models;

use App\Models\DatosAcademicos\Pnf;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    public $table = 'estudiantes';

    public function usuarios()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function pnf()
    {
        return $this->hasOne(Pnf::class, 'id');
    }
}
