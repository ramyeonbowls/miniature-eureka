<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
});

Auth::routes([
    'register' => true,
    'verify' => true,
    'confirm' => true,
    'reset' => true
]);

Route::get('/getInfo', [App\Http\Controllers\MainController::class, 'getInfo'])->name('getInfo');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware('activated.user')->group(function() {
        Route::group(['middleware' => ['role.user:admin']], function () {
            Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
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
        
        Route::group(['middleware' => ['role.user:member']], function () {
            
        });

        Route::get('/403', [App\Http\Controllers\HomeController::class, 'forbidden'])->name('forbidden');

        Route::get('/{any}', [App\Http\Controllers\HomeController::class, 'index'])
            ->where('any', '.*')
            ->name('catch-all')
            ->middleware(['password.confirm']
        );

    });
});
