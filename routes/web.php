<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'register' => true,
    'verify' => true,
    'confirm' => true,
    'reset' => true
]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware('activated.user')->group(function() {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/userinfo', [App\Http\Controllers\HomeController::class, 'userinfo'])->name('userinfo');
    });

    Route::get('/403', [App\Http\Controllers\HomeController::class, 'forbidden'])->name('forbidden');

    Route::get('/{any}', [App\Http\Controllers\HomeController::class, 'index'])
        ->where('any', '.*')
        ->name('catch-all')
        ->middleware(['password.confirm']);
});
