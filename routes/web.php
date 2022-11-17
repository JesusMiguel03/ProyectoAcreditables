<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CourseController;
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

// Home
Route::get('/', function () {
    return view('auth.login');
});

// Student, professor, coordinator home
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'prevent-back-history'
])->group(function () {
    Route::get('/inicio', function () {
        return view('welcome');
    })->name('student.index');
});

Route::get('/coordinador', function () {
    return view('coordinator.index');
})->name('admin.index');

// Users
Route::resource('/usuarios', UserController::class)
    ->middleware(['can:coordinator.index', 'prevent-back-history'])
    ->names('coordinator.users');

// Courses
Route::resource('/cursos', CourseController::class)
    ->middleware('prevent-back-history')
    ->names('courses');

// Frequently asked questions
Route::get('/preguntas-frecuentes', function () {
    return view('faq');
})->middleware('prevent-back-history')
    ->name('faq');
