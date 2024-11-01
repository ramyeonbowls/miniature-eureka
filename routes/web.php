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

Route::middleware('destroy.session')->group(function() {
    Route::post('/mregist', [App\Http\Controllers\Auth\RegisterController::class, 'mregist'])->name('mregist');
    Route::get('/getInfo', [App\Http\Controllers\MainController::class, 'getInfo'])->name('getInfo');
    Route::get('/getAppInfo', [App\Http\Controllers\MainController::class, 'getAppInfo'])->name('getAppInfo');
    Route::get('/getParam', [App\Http\Controllers\MainController::class, 'getParam'])->name('getParam');
    Route::get('/getBukuPopuler', [App\Http\Controllers\MainController::class, 'getBukuPopuler'])->name('getBukuPopuler');
    Route::get('/getBook', [App\Http\Controllers\MainController::class, 'getBook'])->name('getBook');
    Route::get('/getBanner', [App\Http\Controllers\MainController::class, 'getBanner'])->name('getBanner');
    Route::get('/getDetail', [App\Http\Controllers\MainController::class, 'getDetail'])->name('getDetail');
    Route::get('/getCategory', [App\Http\Controllers\MainController::class, 'getCategory'])->name('getCategory');
    Route::get('/getArticle', [App\Http\Controllers\MainController::class, 'getArticle'])->name('getArticle');
    Route::get('/getAllArticle', [App\Http\Controllers\MainController::class, 'getAllArticle'])->name('getAllArticle');
    Route::get('/getDetailArticle', [App\Http\Controllers\MainController::class, 'getDetailArticle'])->name('getDetailArticle');
    Route::get('/getNewCollection', [App\Http\Controllers\MainController::class, 'getNewCollection'])->name('getNewCollection');
    Route::get('/getProfile', [App\Http\Controllers\ProfileController::class, 'index'])->name('getProfile');
    Route::post('/UpdateProfile', [App\Http\Controllers\ProfileController::class, 'UpdateProfile'])->name('UpdateProfile');

    Route::apiResource('form-regis', App\Http\Controllers\FormRegisterController::class);
    Route::get('/agreement-letter', [App\Http\Controllers\FormRegisterController::class, 'exportPDF'])->name('agreement-letter');

    Route::get('/offline-visitor', [App\Http\Controllers\PengunjungOfflineController::class, 'index']);
    Route::post('/offline-visitor', [App\Http\Controllers\PengunjungOfflineController::class, 'store']);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware(['activated.user', 'destroy.session'])->group(function() {
        Route::group(['middleware' => ['role.user:admin,teacher']], function () {
            Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('admin');
            Route::get('/userinfo', [App\Http\Controllers\HomeController::class, 'userinfo'])->name('userinfo');
            Route::get('/dashAtas', [App\Http\Controllers\Core\Dashboard\DashboardController::class, 'dashAtas'])->name('dashAtas');
            Route::get('/my-web-menu', [App\Http\Controllers\HomeController::class, 'webMenuAcl'])->name('web_menu_acl');
    
            Route::middleware([App\Http\Middleware\IfRequestAjax::class])->group(function() {
                Route::namespace('App\Http\Controllers\Core')->group(function() {
                    Route::apiResource('web-access-log', WebAccessLogController::class);
                    Route::post('getOpt', 'OptionController@option')->name('getOpt');
    
                    Route::prefix('master')->namespace('Master')->group(function() {
                        Route::apiResource('member-mst', MemberMasterController::class);
                        Route::apiResource('book-mst', BookMasterController::class);
                        Route::apiResource('library-officer-mst', LibraryOfficerMasterController::class);
                        Route::apiResource('teacher-mst', TeacherMasterController::class);
                    });

                    Route::prefix('setting')->namespace('Setting')->group(function() {
                        Route::apiResource('banner-mst', BannerMasterController::class);
                        Route::apiResource('tajuk-utama-mst', TajukUtamaMasterController::class);
                        Route::apiResource('wawasan-mst', WawasanMasterController::class);
                        Route::apiResource('review-buku-mst', ReviewBukuMasterController::class);
                        Route::apiResource('titik-fokus-mst', TitikFokusMasterController::class);
                        Route::apiResource('humoria-mst', HumoriaMasterController::class);
                        Route::apiResource('layar-penulis-mst', LayarPenulisMasterController::class);
                        Route::apiResource('frasa-mst', FrasaMasterController::class);
                        Route::apiResource('quiz-mst', QuizMasterController::class);
                        
                        Route::apiResource('profile', ProfileMasterController::class);
                        Route::apiResource('appparam', ParameterController::class);
                    });
                    
                    Route::prefix('report')->namespace('Report')->group(function() {
                        Route::get('readbook-rpt', 'ReadBookController@index')->name('readbook-rpt');
                        Route::post('readbook-xls', 'ReadBookController@ExportXLS')->name('readbook-xls');
                        Route::get('readbook-user-rpt', 'ReadBookUserController@index')->name('readbook-user-rpt');
                        Route::post('readbook-user-xls', 'ReadBookUserController@ExportXLS')->name('readbook-user-xls');
                        Route::get('readbook-content-rpt', 'ReadBookContentController@index')->name('readbook-content-rpt');
                        Route::post('readbook-content-xls', 'ReadBookContentController@ExportXLS')->name('readbook-content-xls');;
                        Route::get('books-rpt', 'BookReportController@index')->name('books-rpt');
                        Route::post('books-xls', 'BookReportController@ExportXLS')->name('books-xls');
                        Route::get('member-rpt', 'MemberReportController@index')->name('member-rpt');
                        Route::post('member-xls', 'MemberReportController@ExportXLS')->name('member-xls');
                        Route::get('loans-rpt', 'LoansReportController@index')->name('loans-rpt');
                        Route::post('loans-xls', 'LoansReportController@ExportXLS')->name('loans-xls');
                        Route::get('visitors-rpt', 'VisitorsReportController@index')->name('visitors-rpt');
                        Route::post('visitors-xls', 'VisitorsReportController@ExportXLS')->name('visitors-xls');
                        Route::get('offline-visitors-rpt', 'OfflineVisitorsReportController@index')->name('offline-visitors-rpt');
                        Route::post('offline-visitors-xls', 'OfflineVisitorsReportController@ExportXLS')->name('offline-visitors-xls');
						Route::get('read-fitur-rpt', 'ReadFiturReportController@index')->name('read-fitur-rpt');
                        Route::post('read-fitur-xls', 'ReadFiturReportController@ExportXLS')->name('read-fitur-xls');
						Route::get('library-officer-rpt', 'LibraryOfficerReportController@index')->name('library-officer-rpt');
                        Route::post('library-officer-xls', 'LibraryOfficerReportController@ExportXLS')->name('library-officer-xls');
                    });
                });
            }); 
        });
        
        Route::group(['middleware' => ['role.user:member']], function () {
            Route::get('/RentHistory', [App\Http\Controllers\BookController::class, 'RentHistory'])->name('RentHistory');
            Route::post('/ReturnBook', [App\Http\Controllers\BookController::class, 'ReturnBook'])->name('ReturnBook');
            Route::post('/RentBook', [App\Http\Controllers\BookController::class, 'RentBook'])->name('RentBook');
            Route::post('/LastRead', [App\Http\Controllers\BookController::class, 'LastRead'])->name('LastRead');
            Route::get('/ReadCheck', [App\Http\Controllers\BookController::class, 'ReadCheck'])->name('ReadCheck');
            Route::get('/appreader', [App\Http\Controllers\BookController::class, 'index'])->name('appreader');
            Route::get('/book-pdf', [App\Http\Controllers\BookController::class, 'getBook'])->name('book-pdf');
			Route::get('/getQuiz', [App\Http\Controllers\QuizTransactionController::class, 'index'])->name('getQuiz');
			Route::post('/setQuiz', [App\Http\Controllers\QuizTransactionController::class, 'store'])->name('setQuiz');
			Route::get('/getDetailQuiz', [App\Http\Controllers\QuizTransactionController::class, 'getDetailQuiz'])->name('getDetailQuiz');
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
