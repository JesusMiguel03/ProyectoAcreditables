<?php

namespace App\Models\Academico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaConocimiento extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'conocimientos';

    protected $fillable = ['nom_conocimiento', 'desc_conocimiento'];

    public function profesores()
    {
        return $this->hasMany(Profesor::class);
    }
}
