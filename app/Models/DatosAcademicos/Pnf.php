<?php

namespace App\Models\DatosAcademicos;

use App\Models\Estudiante;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pnf extends Model
{
    use HasFactory;

    public $table = 'pnf';

    protected $fillable = ['nom_pnf', 'cod_pnf'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'pnf_id');
    }
}
