<?php

namespace App\Models\Informacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Noticia extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'noticias';

    protected $fillable = ['encabezado', 'desc_noticia', 'imagen_noticia', 'mostrar'];
}
