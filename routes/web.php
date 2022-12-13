<?php

use App\Http\Controllers\Academico\PeriodoController;
use App\Http\Controllers\Coordinador\EspecialidadController;
use App\Http\Controllers\Coordinador\ProfesorController;
use App\Http\Controllers\Coordinador\RegistrarEstudianteController;
use App\Http\Controllers\Coordinador\RegistrarProfesorController;
use App\Http\Controllers\Coordinador\UsuarioController;
use App\Http\Controllers\Materia\CategoriaController;
use App\Http\Controllers\Materia\InscripcionController;
use App\Http\Controllers\DatosAcademicos\PnfController;
use App\Http\Controllers\DatosAcademicos\TrayectoController;
use App\Http\Controllers\Estudiante\EstudianteController;
use App\Http\Controllers\Informacion\InicioController;
use App\Http\Controllers\Informacion\NoticiasController;
use App\Http\Controllers\Informacion\PreguntasFrecuentesController;
use App\Http\Controllers\Materia\AsistenciaController as MateriaAsistenciaController;
use App\Http\Controllers\Materia\ListadoController;
use App\Http\Controllers\Materia\MateriaController;
use App\Http\Controllers\Perfil\ContrasenaController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Route;

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

// Inicio
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'prevent-back-history'
])->group(function () {
    Route::resource('/', InicioController::class)->only([
        'index'
    ])->names('inicio');
});

// Áreas de conocimiento
Route::resource('/conocimiento', EspecialidadController::class)->middleware('prevent-back-history')->except([
    'create', 'show', 'destroy'
]);

// Profesor
Route::resource('/profesores', ProfesorController::class)->middleware('prevent-back-history')->except([
    'create', 'destroy'
]);
Route::post('/registrar-profesor', [RegistrarProfesorController::class, 'store'])->middleware('prevent-back-history')->name('registrar-profesor');

// Usuarios [Solo para coordinador]
Route::resource('/usuarios', UsuarioController::class)
    ->middleware('prevent-back-history')
    ->names('coordinador.usuarios');

// Categorias
Route::resource('/categoria', CategoriaController::class)->middleware('prevent-back-history')->except([
    'create', 'show', 'destroy'
]);
    
// Materias
Route::resource('/materias', MateriaController::class)
    ->except('create')
    ->middleware('prevent-back-history')
    ->names('materias');
Route::get('listado/{id}', [ListadoController::class, 'show'])->middleware('prevent-back-history')->name('listadoEstudiantes');

// Asistencia
Route::get('/asistencia', [MateriaAsistenciaController::class, 'index'])->middleware(['prevent-back-history'])->name('asistencia');
Route::get('/asistencia/{id}', [MateriaAsistenciaController::class, 'edit'])->middleware(['prevent-back-history'])->name('asistencia-ver');
Route::post('/asistencia/actualizar', [MateriaAsistenciaController::class, 'update'])->middleware(['prevent-back-history'])->name('asistencia-actualizar');

// PNF
Route::resource('/pnf', PnfController::class)->middleware('prevent-back-history')->except([
    'create', 'show', 'destroy'
]);

// Trayecto
Route::resource('/trayecto', TrayectoController::class)->middleware('prevent-back-history')->except([
    'create', 'show', 'destroy'
]);

// Noticias
Route::resource('/noticias', NoticiasController::class)
    ->middleware('prevent-back-history')
    ->only('index', 'store', 'edit', 'update');

// Preguntas frecuentes
Route::resource('/preguntas-frecuentes', PreguntasFrecuentesController::class)
    ->middleware('prevent-back-history')
    ->only(['index', 'store', 'edit', 'update'])
    ->names('preguntas');

// Perfil
Route::resource('/perfil', PerfilController::class)->middleware('prevent-back-history')->only('index');
Route::put('/perfil/actualizar-contrasena', [ContrasenaController::class, 'update'])->middleware('prevent-back-history')->name('actualizarContrasena');

// Inscripcion
Route::resource('/preinscripcion', InscripcionController::class)->middleware('prevent-back-history')->only('store');

// Estudiante
Route::resource('/estudiante', EstudianteController::class)->middleware('prevent-back-history')->only('store');
Route::post('/registrar-estudiante', [RegistrarEstudianteController::class, 'store'])->middleware('prevent-back-history')->name('registrar-estudiante');
Route::get('/estudiante/comprobante/{id}', [EstudianteController::class, 'comprobante'])->middleware('prevent-back-history')->name('comprobante');
Route::post('/validar', [InscripcionController::class, 'validar'])->middleware('prevent-back-history')->name('validacion');
Route::post('/invalidar', [InscripcionController::class, 'invalidar'])->middleware('prevent-back-history')->name('invalidacion');
Route::get('/materias/inscribir/{id}', [InscripcionController::class, 'inscribir'])->middleware('prevent-back-history')->name('inscribir');

// Periodo
Route::get('/periodo', [PeriodoController::class, 'index'])->middleware('prevent-back-history')->name('periodo');
Route::post('/periodo/store', [PeriodoController::class, 'store'])->middleware('prevent-back-history')->name('periodo.store');
Route::get('/periodo/{id}/edit', [PeriodoController::class, 'edit'])->middleware('prevent-back-history')->name('periodo.edit');
Route::put('/periodo/update', [PeriodoController::class, 'update'])->middleware('prevent-back-history')->name('periodo.update');