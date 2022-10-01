<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\ProfessorProfilesController;

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

Route::view('/', 'welcome')->name('home');
Route::resource('/cursos', CoursesController::class, [
    'names' => 'cursos',
    'parameters' => ['course' => 'curso']
]);
Route::resource('/perfiles', ProfessorProfilesController::class, [
    'names' => 'perfiles',
    'parameters' => ['profile' => 'perfil']
]);
