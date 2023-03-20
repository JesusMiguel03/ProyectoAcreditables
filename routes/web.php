<?php

use App\Http\Controllers\Academico\AreaConocimientoController;
use App\Http\Controllers\Academico\EstudianteController;
use App\Http\Controllers\Academico\HorarioController;
use App\Http\Controllers\Academico\PeriodoController;
use App\Http\Controllers\Academico\PNFController;
use App\Http\Controllers\Academico\ProfesorController;
use App\Http\Controllers\Academico\TrayectoController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\Estadisticas\EstadisticasController;
use App\Http\Controllers\Informacion\InicioController;
use App\Http\Controllers\Informacion\NoticiaController;
use App\Http\Controllers\Informacion\PreguntaFrecuenteController;
use App\Http\Controllers\Materia\CategoriaController;
use App\Http\Controllers\Materia\InscripcionController;
use App\Http\Controllers\Materia\AsistenciaController;
use App\Http\Controllers\Materia\ListadoController;
use App\Http\Controllers\Materia\MateriaController;
use App\Http\Controllers\Perfil\ContrasenaController;
use App\Http\Controllers\Perfil\UsuarioController;
use App\Http\Controllers\Perfil\PerfilController;
use App\Http\Controllers\RegistrarUsuarioController;
use App\Http\Controllers\Soporte\BaseDeDatosController;
use App\Http\Controllers\Soporte\SoporteController;
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

/**
 * PRINCIPAL
 * 1. Inicio
 * 2. Periodo
 * 3. Registrar
 *      3.1 Áreas de conocimiento
 *      3.2 Profesores
 *      3.3 Estudiantes
 */

// 1. Inicio
Route::get('/', [InicioController::class, 'index'])
    ->middleware(['auth:sanctum', config('jetstream.auth_session', 'verified', 'prevent-back-history')])
    ->name('inicio.index');

// 2. Periodo
Route::controller(PeriodoController::class)->group(function () {
    Route::get('/periodos', 'index')->name('periodos.index');
    Route::post('/periodos/store', 'store')->name('periodos.store');
    Route::get('/periodos/{id}/edit', 'edit')->name('periodos.edit');
    Route::put('/periodos/{id}/update', 'update')->name('periodos.update');
});

// 3.1 Áreas de conocimiento
Route::controller(AreaConocimientoController::class)->group(function () {
    Route::get('/conocimientos', 'index')->name('conocimientos.index');
    Route::post('/conocimientos/store', 'store')->name('conocimientos.store');
    Route::get('/conocimientos/{id}/edit', 'edit')->name('conocimientos.edit');
    Route::put('/conocimientos/{id}/update', 'update')->name('conocimientos.update');
    Route::delete('/conocimientos/{id}/delete', 'delete')->name('conocimientos.destroy');
});

// 3.2 Profesor
Route::controller(ProfesorController::class)->group(function () {
    Route::get('/profesores', 'index')->name('profesores.index');
    Route::post('/profesores/store', 'store')->name('profesores.store');
    Route::get('/profesores/{id}/edit', 'edit')->name('profesores.edit');
    Route::get('/profesores/{id}', 'show')->name('profesores.show');
    Route::put('/profesores/{id}/update', 'update')->name('profesores.update');
});

// 3.3 Estudiantes [Solo para coordinador]
Route::controller(UsuarioController::class)->group(function () {
    Route::get('/estudiantes', 'index')->name('estudiantes.index');
    Route::get('/estudiantes/{id}/edit', 'edit')->name('estudiantes.edit');
    Route::put('/estudiantes/{id}/update', 'update')->name('estudiantes.update');
    Route::put('/estudiante/{id}/aprobar', 'aprobar')->name('estudiantes.aprobar');
});

// Registrar estudiante o profesor
Route::post('/registrar-usuario/{rol}', [RegistrarUsuarioController::class, 'store'])->name('registrar.usuario');

/**
 * ACREDITABLES
 * 1. Gestionar
 *  1.1. Categorias
 *  1.2. Materias
 *      1.2.1 Listado de estudiantes
 *      1.2.2 Inscripción
 *      1.2.3 Comprobante de inscripción
 *  1.3. Horarios
 *  1.4. Asistencias
 * 2. Gráficos y estadísticas
 */

// 1.1. Categorias
Route::controller(CategoriaController::class)->group(function () {
    Route::get('/categorias', 'index')->name('categorias.index');
    Route::post('/categorias/store', 'store')->name('categorias.store');
    Route::get('/categorias/{id}/edit', 'edit')->name('categorias.edit');
    Route::get('/categorias/{id}', 'show')->name('categorias.show');
    Route::put('/categorias/{id}/update', 'update')->name('categorias.update');
    Route::delete('/categorias/{id}/delete', 'delete')->name('categorias.destroy');
});

// 1.2. Materias
Route::controller(MateriaController::class)->group(function () {
    Route::get('/materias', 'index')->name('materias.index');
    Route::post('/materias/store', 'store')->name('materias.store');
    Route::get('/materias/{id}/edit', 'edit')->name('materias.edit');
    Route::get('/materias/{id}', 'show')->name('materias.show');
    Route::put('/materias/{id}/update', 'update')->name('materias.update');
    Route::delete('/materias/{id}/delete', 'delete')->name('materias.destroy');
});

// 1.2.1 Listado de estudiantes por materia
Route::get('listado/{id}', [ListadoController::class, 'show'])->name('listadoEstudiantes');

// 1.2.2 Inscripcion
Route::controller(InscripcionController::class)->group(function () {
    Route::post('/inscripcion', 'store')->name('inscripcion.store');
    Route::post('/inscripcion/{id}/{materia_id}/cambiar', 'cambiar')->name('inscripcion.cambiar');
    Route::post('/inscripcion/{id}/validar', 'validar')->name('validacion');
    Route::post('/inscripcion/{id}/invalidar', 'invalidar')->name('invalidacion');
    Route::get('/materias/{id}/inscribir', 'inscribir')->name('inscribir');
    Route::post('/estudiantes/{id}/nota', 'asignarNota')->name('asignar.nota');
});

// 1.2.3 Comprobante
Route::get('/estudiante/{id}/comprobante/{nroComprobante?}', [EstudianteController::class, 'comprobante'])->name('comprobante');

// 1.3. Horarios
Route::controller(HorarioController::class)->group(function () {
    Route::get('/horarios', 'index')->name('horarios.index');
    Route::post('/horarios/store', 'store')->name('horarios.store');
    Route::post('/horarios/{id}/edit', 'edit')->name('horarios.edit');
    Route::put('/horarios/{id}/update', 'update')->name('horarios.update');
    Route::delete('/horarios/{id}/delete', 'delete')->name('horarios.destroy');
    Route::get('/horarios/pdf', 'pdf')->name('horarios.pdf');
    Route::post('/horarios/vaciar', 'vaciar')->name('horarios.vaciar');
});

// 1.4. Asistencia
Route::controller(AsistenciaController::class)->group(function () {
    Route::get('/asistencias', 'index')->name('asistencias.index');
    Route::get('/asistencias/{id}', 'edit')->name('asistencias.edit');
    Route::put('/asistencias/{id}/actualizar', 'update')->name('asistencias.update');
});

// 2.Estadísticas
Route::controller(EstadisticasController::class)->group(function () {
    Route::get('/estadisticas', 'index')->name('estadisticas.index');
    Route::get('/estadisticas/{periodo_id?}', 'estadisticas')->name('estadisticas.show');
    Route::get('/estadisticas/{periodo_id?}/{materia_id?}', 'materia')->name('estadisticas.materia');
});

/**
 * DATOS ACADÉMICOS
 * 1. PNF
 * 2. Trayecto
 */

// 1. PNF
Route::controller(PNFController::class)->group(function () {
    Route::get('/pnfs', 'index')->name('pnfs.index');
    Route::post('/pnfs/store', 'store')->name('pnfs.store');
    Route::get('/pnfs/{id}/edit', 'edit')->name('pnfs.edit');
    Route::put('/pnfs/{id}/update', 'update')->name('pnfs.update');
    Route::delete('/pnfs/{id}/delete', 'delete')->name('pnfs.destroy');
});

// 2. Trayecto
Route::controller(TrayectoController::class)->group(function () {
    Route::get('/trayectos', 'index')->name('trayectos.index');
    Route::post('/trayectos/store', 'store')->name('trayectos.store');
    Route::get('/trayectos/{id}/edit', 'edit')->name('trayectos.edit');
    Route::put('/trayectos/{id}/update', 'update')->name('trayectos.update');
    Route::delete('/trayectos/{id}/delete', 'delete')->name('trayectos.destroy');
});

/**
 * INFORMACIÓN
 * 1. Noticias
 * 2. Preguntas frecuentes / Acerca de
 */

// Noticias
Route::controller(NoticiaController::class)->group(function () {
    Route::get('/noticias', 'index')->name('noticias.index');
    Route::post('/noticias/store', 'store')->name('noticias.store');
    Route::get('/noticias/{id}/edit', 'edit')->name('noticias.edit');
    Route::put('/noticias/{id}/update', 'update')->name('noticias.update');
    Route::delete('/noticias/{id}/delete', 'delete')->name('noticias.destroy');
});

// Preguntas frecuentes
Route::controller(PreguntaFrecuenteController::class)->group(function () {
    Route::get('/preguntas-frecuentes', 'index')->name('preguntas.index');
    Route::post('/preguntas-frecuentes/store', 'store')->name('preguntas.store');
    Route::get('/preguntas-frecuentes/{id}/edit', 'edit')->name('preguntas.edit');
    Route::put('/preguntas-frecuentes/{id}/update', 'update')->name('preguntas.update');
    Route::delete('/preguntas-frecuentes/{id}/delete', 'delete')->name('preguntas.destroy');
});

/**
 *  Mantenimiento
 */

// Soporte
Route::controller(SoporteController::class)->group(function () {
    Route::get('/soporte/recuperar-elementos', 'restaurarElementos')->name('soporte.elementosBorrados');
    Route::get('/soporte/{id}/{modelo}', 'recuperar')->name('soporte.recuperar');
    Route::get('/soporte', 'index')->name('soporte.index');
    Route::put('/soporte/recuperar-contrasena', 'recuperarContrasena')->name('soporte.recuperarContrasena');
    Route::put('/soporte/cambiar-cedula', 'cambiarCedula')->name('soporte.cambiarCedula');
});

// Base de datos
Route::controller(BaseDeDatosController::class)->group(function () {
    Route::get('/base-de-datos', 'index')->name('baseDatos');
    Route::get('/base-de-datos/guardar', 'guardar')->name('guardar-base-de-datos');
    Route::get('/base-de-datos/descargar/{archivo}', 'descargar')->name('descargar-base-de-datos');
});

// Bitacora
Route::get('/bitacora', [BitacoraController::class, 'index'])->name('bitacora');


/**
 * MI PERFIL
 * 1. Inicio
 * 2. Actualizar perfil
 * 3. Actualizar contraseña
 */

Route::controller(PerfilController::class)->group(function () {
    //  1. Inicio
    Route::get('/perfil', 'index')->name('perfil.index');

    // 2. Actualizar perfil
    Route::put('/perfil/{id}/update', 'update')->name('perfil.avatar');
});

// 3. Actualizar contraseña
Route::put('/perfil/{id}/actualizar-contrasena', [ContrasenaController::class, 'update'])->name('actualizarContrasena');