<?php

return [
    /*
    |--------------------------------------------------------------------------
    | INFORMACIÓN
    |--------------------------------------------------------------------------
    |
    | En este archivo se encuentran todas las variables importantes que se usan
    | en el proyecto, tales como la cantidad de caracteres permitidos por campos,
    / su tipo u otro valor.
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

    'carrusel' => 10,

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
    | Límite de caracteres por campo
    |
    */

    'regex' => [
        'alfanumerico' => "/^[\w\s]*$/",
    ],

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
        'titulo' => 25,
        'descripcion' => 60,
        'imagen' => 80,
    ],

    'preguntas' => [
        'titulo' => 30,
        'explicacion' => 255
    ],

    'horarios' => [
        'espacio' => 30,
        'edificio' => 12,
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
        'nota' => 3,
        'codigo' => 20
    ],
];