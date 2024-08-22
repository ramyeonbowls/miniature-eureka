<?php

use Illuminate\Support\Facades\Route;

Auth::routes([
    'register' => true,
    'verify' => false,
    'confirm' => true,
    'reset' => true
]);

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/{any}', [App\Http\Controllers\HomeController::class, 'index'])
        ->where('any', '.*')
        ->name('catch-all')
        ->middleware(['password.confirm']);
});
