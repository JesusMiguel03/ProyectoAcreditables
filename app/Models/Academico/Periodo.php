<?php

namespace App\Models\Academico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Periodo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'periodos';

    protected $fillable = [
        'fase', 'inicio', 'fin'
    ];

    public function formato()
    {
        $conversor = [1 => 'I', 2 => 'II', 3 => 'III'];
        return "{$conversor[$this->fase]} - {Carbon::parse($this->inicio)->format('Y')}";
    }
}
