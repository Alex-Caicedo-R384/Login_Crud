<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ComputerController;
use App\Http\Controllers\GpuController;
use App\Http\Controllers\ProcessorController;


Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('computers', ComputerController::class);
    Route::resource('gpus', GpuController::class);
    Route::resource('processors', ProcessorController::class);
});
