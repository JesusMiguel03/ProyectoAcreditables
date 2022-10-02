<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ProfessorUserController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\LoginUserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RecoverPasswordController;
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

Route::resource('/', HomeController::class);
Route::resource('/admin', AdminUserController::class);
Route::resource('/professor', ProfessorUserController::class);

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

Route::view('/register', 'account.register')->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::view('/login', 'account.login')->name('login');
Route::post('/login', [LoginUserController::class, 'store']);

Route::view('/forgot-password', 'account.forgot-password')->name('forgotPassword');
Route::post('/forgot-password', [ForgotPasswordController::class, 'store']);

Route::view('/recover-password', 'account.recover-password')->name('recoverPassword');
Route::post('/recover-password', [RecoverPasswordController::class, 'store']);
