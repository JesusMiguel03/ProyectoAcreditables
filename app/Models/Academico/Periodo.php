<?php

namespace App\Models\Academico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Periodo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'periodos';

    protected $fillable = [
        'fase', 'inicio', 'fin'
    ];
}
