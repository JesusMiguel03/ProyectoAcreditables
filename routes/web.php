<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\ProfessorProfilesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FAQController;

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
Route::resource('/estudiantes', StudentController::class, [
    'names' => 'estudiantes',
    'parameters' => ['student' => 'estudiante']
]);
Route::resource('/faq', FAQController::class);

Route::view('/login', 'account.login')->name('login');
Route::post('/login', [RegisteredUserController::class, 'store']);
Route::post('/login', [RegisteredUserController::class, 'destroy'])->name('logout');

Route::view('/register', 'account.register')->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
