<?php

return [
    /*
    |--------------------------------------------------------------------------
    | INFORMACIÓN
    |--------------------------------------------------------------------------
    |
    | En este archivo se encuentran todas las variables importantes que se usan
    | en el proyecto, tales como los ellimite de un campo, su tipo u otro valor.
    | Algunos valores se aconseja se mantengan por defecto para no provocar mal
    | funcionamiento de la página.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Carruseles
    |--------------------------------------------------------------------------
    |
    | Todos los carruseles se ven atados a la misma variable, esta equivale al
    | número de elementos a mostrar, para aquellos elementos fuera del carrusel
    | se muestran a través de una tabla.
    |
    */

    'carrusel' => 8,

    /*
    |--------------------------------------------------------------------------
    | Pluck
    |--------------------------------------------------------------------------
    |
    | Limita la cantidad de modelos a cargar.
    |
    */

    'limite' => 50,

    /*
    |--------------------------------------------------------------------------
    | Migraciones
    |--------------------------------------------------------------------------
    |
    | Límite de carácteres por campo
    |
    */

    'usuarios' => [
        'nombre' => 20,
        'apellido' => 20,
        'cedula' => [7, 8],
        'correo' => 255,
        'avatar' => 80
    ],

    'categorias' => [
        'nombre' => 50
    ],

    'conocimiento' => [
        'nombre' => 50,
        'descripcion' => 255
    ],

    'pnfs' => [
        'nombre' => 30,
        'codigo' => 6
    ],

    'noticias' => [
        'encabezado' => 25,
        'descripcion' => 60,
        'imagen' => 80,
    ],

    'preguntas' => [
        'titulo' => 30,
        'explicacion' => 255
    ],

    'horarios' => [
        'espacio' => 30,
        'edificio_numero' => 12,
    ],

    'profesores' => [
        'estado' => 16,
        'ciudad' => 30,
        'urb' => 20,
        'calle' => 20,
        'casa' => 10,
        'telefono' => 11,
    ],

    'informacion_materia' => [
      'metodologia'   => 16
    ],

    'materias' => [
        'nombre' => 25,
        'cupos' => 50,
        'descripcion' => 255,
        'estado' => 20,
        'numero' => 4,
        'imagen' => 80
    ],

    'estudiante_materia' => [
        'calificacion' => 3,
        'codigo' => 20
    ],
];