<?php

namespace App\Models\Informacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Noticia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'noticias';

    protected $fillable = ['titulo', 'desc_noticia', 'imagen_noticia', 'activo'];

    public function scopeCreadoEntre($query, array $fechas)
    {
        $inicio = ($fechas[0] instanceof Carbon) ? $fechas[0] : Carbon::parse($fechas[0])->startOfDay();
        $fin = ($fechas[1] instanceof Carbon) ? $fechas[1] : Carbon::parse($fechas[1])->endOfDay();

        return $query->whereBetween('created_at', [$inicio, $fin]);
    }
}
