<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ComputerController;
use App\Http\Controllers\GpuController;
use App\Http\Controllers\ProcessorController;
use App\Http\Controllers\JuegoController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\BenchmarkController;
use App\Http\Controllers\JuegoBenchmarkController;


Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('computers', ComputerController::class);
    Route::resource('gpus', GpuController::class);
    Route::resource('processors', ProcessorController::class);
    Route::resource('juegos', JuegoController::class);
    Route::resource('configuracion', ConfiguracionController::class);
    Route::resource('benchmark', BenchmarkController::class);
    Route::get('/benchmarks', [JuegoBenchmarkController::class, 'index'])->name('benchmarks.index');
    Route::get('/benchmarks/{id}', [JuegoBenchmarkController::class, 'show'])->name('benchmarks.show');
});
