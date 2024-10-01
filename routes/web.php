<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('main');
});

Route::get('/form-register', function () {
    return view('formregister');
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/resend', [VerificationController::class, 'resend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.resend');

Auth::routes([
    'register' => true,
    'verify' => true,
    'confirm' => true,
    'reset' => true
]);

Route::post('/mregist', [App\Http\Controllers\Auth\RegisterController::class, 'mregist'])->name('mregist');
Route::get('/getInfo', [App\Http\Controllers\MainController::class, 'getInfo'])->name('getInfo');
Route::get('/getBukuPopuler', [App\Http\Controllers\MainController::class, 'getBukuPopuler'])->name('getBukuPopuler');
Route::get('/getBook', [App\Http\Controllers\MainController::class, 'getBook'])->name('getBook');
Route::get('/getBanner', [App\Http\Controllers\MainController::class, 'getBanner'])->name('getBanner');
Route::get('/getDetail', [App\Http\Controllers\MainController::class, 'getDetail'])->name('getDetail');
Route::get('/getCategory', [App\Http\Controllers\MainController::class, 'getCategory'])->name('getCategory');
Route::get('/getArticle', [App\Http\Controllers\MainController::class, 'getArticle'])->name('getArticle');
Route::get('/getAllArticle', [App\Http\Controllers\MainController::class, 'getAllArticle'])->name('getAllArticle');
Route::get('/getDetailArticle', [App\Http\Controllers\MainController::class, 'getDetailArticle'])->name('getDetailArticle');
Route::get('/getProfile', [App\Http\Controllers\MainController::class, 'getProfile'])->name('getProfile');
Route::get('/getNewCollection', [App\Http\Controllers\MainController::class, 'getNewCollection'])->name('getNewCollection');

Route::apiResource('form-regis', App\Http\Controllers\FormRegisterController::class);
Route::get('/agreement-letter', [App\Http\Controllers\FormRegisterController::class, 'exportPDF'])->name('agreement-letter');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware('activated.user')->group(function() {
        Route::group(['middleware' => ['role.user:admin']], function () {
            Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('admin');
            Route::get('/userinfo', [App\Http\Controllers\HomeController::class, 'userinfo'])->name('userinfo');
            Route::get('/my-web-menu', [App\Http\Controllers\HomeController::class, 'webMenuAcl'])->name('web_menu_acl');
    
            Route::middleware([App\Http\Middleware\IfRequestAjax::class])->group(function() {
                Route::namespace('App\Http\Controllers\Core')->group(function() {
                    Route::apiResource('web-access-log', WebAccessLogController::class);
    
                    Route::prefix('setting')->namespace('Setting')->group(function() {
                        Route::apiResource('banner-mst', BannerMasterController::class);
                    });
                });
            }); 
        });
        
        Route::group(['middleware' => ['role.user:member']], function () {
            Route::post('/LastRead', [App\Http\Controllers\BookController::class, 'LastRead'])->name('LastRead');
            Route::get('/ReadCheck', [App\Http\Controllers\BookController::class, 'ReadCheck'])->name('ReadCheck');
            Route::get('/appreader', [App\Http\Controllers\BookController::class, 'index'])->name('appreader');
            Route::get('/book-pdf', [App\Http\Controllers\BookController::class, 'getBook'])->name('book-pdf');
        });

        Route::controller(App\Http\Controllers\HomeController::class)->group(function () {
            Route::get('/403', 'forbidden')->name('forbidden');
            Route::get('/{any}', 'index')
                ->where('any', '.*')
                ->name('catch-all-admin')
                ->middleware(['activated.user']);
        });

    });
});

Route::get('/{any}', [App\Http\Controllers\MainController::class, 'index'])
    ->where('any', '.*')
    ->name('catch-all')
    ->middleware('auth.role');
