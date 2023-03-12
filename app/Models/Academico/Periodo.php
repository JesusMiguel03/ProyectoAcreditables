<?php

namespace App\Models\Academico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Periodo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'periodos';

    protected $fillable = [
        'fase', 'inicio', 'fin'
    ];

    public function finalizado()
    {
        $fechaHoy = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
        $finPeriodo = Carbon::parse($this->fin)->format('Y-m-d H:i:s');

        return $fechaHoy >= $finPeriodo;
    }

    public function formato()
    {
        $conversor = [1 => 'I', 2 => 'II', 3 => 'III'];
        return $conversor[$this->fase] . '-' . Carbon::parse($this->inicio)->format('Y');
    }
}
