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
        Route::get('/my-web-menu', [App\Http\Controllers\HomeController::class, 'webMenuAcl'])->name('web_menu_acl');

        Route::middleware([App\Http\Middleware\IfRequestAjax::class])->group(function() {
            Route::namespace('App\Http\Controllers\Core')->group(function() {
                Route::apiResource('web-access-log', WebAccessLogController::class);

                Route::prefix('setting')->namespace('Settings')->group(function() {
                    Route::apiResource('web-role', WebRoleMenuController::class);
                });
            });
        });
    });

    Route::get('/403', [App\Http\Controllers\HomeController::class, 'forbidden'])->name('forbidden');

    Route::get('/{any}', [App\Http\Controllers\HomeController::class, 'index'])
        ->where('any', '.*')
        ->name('catch-all')
        ->middleware(['password.confirm']);
});
