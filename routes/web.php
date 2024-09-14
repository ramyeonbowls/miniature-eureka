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
Route::get('/getBukuPopuler', [App\Http\Controllers\MainController::class, 'getBukuPopuler'])->name('getBukuPopuler');
Route::get('/getBook', [App\Http\Controllers\MainController::class, 'getBook'])->name('getBook');
Route::get('/getDetail', [App\Http\Controllers\MainController::class, 'getDetail'])->name('getDetail');
Route::get('/getCategory', [App\Http\Controllers\MainController::class, 'getCategory'])->name('getCategory');

Route::get('/appreader', [App\Http\Controllers\BookController::class, 'index']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware('activated.user')->group(function() {
        Route::group(['middleware' => ['role.user:admin']], function () {
            Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('admin');
            Route::get('/userinfo', [App\Http\Controllers\HomeController::class, 'userinfo'])->name('userinfo');
            Route::get('/my-web-menu', [App\Http\Controllers\HomeController::class, 'webMenuAcl'])->name('web_menu_acl');
    
            Route::middleware([App\Http\Middleware\IfRequestAjax::class])->group(function() {
                Route::namespace('App\Http\Controllers\Core')->group(function() {
                    Route::apiResource('web-access-log', WebAccessLogController::class);
    
                    /* Route::prefix('setting')->namespace('Settings')->group(function() {
                        Route::apiResource('web-role', WebRoleMenuController::class);
                    }); */
                });
            }); 
        });
        
        Route::group(['middleware' => ['role.user:member']], function () {
            
        });

        Route::controller(App\Http\Controllers\HomeController::class)->group(function () {
            Route::get('/403', 'forbidden')->name('forbidden');
            Route::get('/{any}', 'index')
                ->where('any', '.*')
                ->name('catch-all')
                ->middleware(['activated.user']);
        });

    });
});

Route::get('/{any}', [App\Http\Controllers\MainController::class, 'index'])
    ->where('any', '.*')
    ->name('catch-all');
