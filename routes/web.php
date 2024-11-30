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
use App\Http\Middleware\CheckAdmin;
use App\Http\Controllers\AjusteRecomendadoController;


Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/benchmarks', [JuegoBenchmarkController::class, 'index'])->name('benchmarks.index');
    Route::get('/benchmarks/{id}', [JuegoBenchmarkController::class, 'show'])->name('benchmarks.show');
    Route::resource('benchmark', BenchmarkController::class);
});

Route::middleware(['auth', CheckAdmin::class])->group(function () {
    Route::resource('computers', ComputerController::class);
    Route::resource('gpus', GpuController::class);
    Route::resource('processors', ProcessorController::class);
    Route::resource('juegos', JuegoController::class);
    Route::resource('configuracion', ConfiguracionController::class);
    Route::resource('ajustes', AjusteRecomendadoController::class);

    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/admin/settings', [SettingsController::class, 'index'])->name('admin.settings');
});