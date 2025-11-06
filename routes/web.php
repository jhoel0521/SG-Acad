<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('materias', \App\Http\Controllers\MateriaController::class);

    Route::prefix('docente')->name('docente.')->middleware('role:docente')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\DocenteController::class, 'dashboard'])->name('dashboard');
        Route::get('/materias/{materia}/estudiantes', [\App\Http\Controllers\DocenteController::class, 'estudiantes'])->name('estudiantes');
        Route::get('/materias/{materia}/asistencia', [\App\Http\Controllers\DocenteController::class, 'tomarAsistencia'])->name('asistencia');
        Route::post('/materias/{materia}/asistencia', [\App\Http\Controllers\DocenteController::class, 'guardarAsistencia'])->name('guardar_asistencia');
        Route::get('/materias/{materia}/calificaciones', [\App\Http\Controllers\DocenteController::class, 'calificaciones'])->name('calificaciones');
        Route::post('/materias/{materia}/calificaciones', [\App\Http\Controllers\DocenteController::class, 'guardarCalificaciones'])->name('guardar_calificaciones');
    });
});

require __DIR__.'/auth.php';
