<?php

use App\Http\Controllers\Coordinador\EspecialidadController;
use App\Http\Controllers\Coordinador\ProfesorController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Coordinador\UsuarioController;
use App\Http\Controllers\Materia\CategoriaController;
use App\Http\Controllers\Materia\PreinscripcionController;
use App\Http\Controllers\DatosAcademicos\PnfController;
use App\Http\Controllers\DatosAcademicos\TrayectoController;
use App\Http\Controllers\Informacion\InicioController;
use App\Http\Controllers\Informacion\NoticiasController;
use App\Http\Controllers\Informacion\PreguntasFrecuentesController;
use App\Http\Controllers\Materia\MateriaController;
use App\Http\Controllers\PerfilController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Iniciar sesion
Route::get('/', function () {
    return view('auth.login');
});

// Inicio
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'prevent-back-history'
])->group(function () {
    Route::resource('/inicio', InicioController::class)->only([
        'index'
    ])->names('inicio');
});

// Usuarios [Solo para coordinador]
Route::resource('/usuarios', UsuarioController::class)
    ->middleware('prevent-back-history')
    ->names('coordinador.usuarios');

// Materias
Route::resource('/materias', MateriaController::class)
    ->except('create')
    ->middleware('prevent-back-history')
    ->names('materias');

// Categorias
Route::resource('/categoria', CategoriaController::class)->middleware('prevent-back-history')->except([
    'create', 'show', 'destroy'
]);

// Horario
// Route::resource('/horario', HorarioController::class)->except([
//     'create', 'show', 'destroy'
// ]);

// Especialidad
Route::resource('/especialidad', EspecialidadController::class)->middleware('prevent-back-history')->except([
    'create', 'show', 'destroy'
]);

// Profesor
Route::resource('/profesores', ProfesorController::class)->middleware('prevent-back-history')->except([
    'create', 'destroy'
]);

// Trayecto
Route::resource('/trayecto', TrayectoController::class)->middleware('prevent-back-history')->except([
    'create', 'show', 'destroy'
]);

// Pnf
Route::resource('/pnf', PnfController::class)->middleware('prevent-back-history')->except([
    'create', 'show', 'destroy'
]);

// Inscripcion
Route::resource('/estudiante', PreinscripcionController::class)->middleware('prevent-back-history')->only('store');

// Perfil
Route::resource('/perfil', PerfilController::class)->middleware('prevent-back-history')->only('index', 'edit', 'update');

// Noticias
Route::resource('/noticias', NoticiasController::class)
    ->middleware('prevent-back-history')
    ->only('index', 'store', 'edit', 'update');

// Preguntas frecuentes
Route::resource('/preguntas-frecuentes', PreguntasFrecuentesController::class)
    ->middleware('prevent-back-history')
    ->only(['index', 'store', 'edit', 'update'])
    ->names('preguntas');
