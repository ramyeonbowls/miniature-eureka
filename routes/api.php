<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Core\VisitorsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/visit', [VisitorsController::class, 'store']);
Route::post('/ReadFitur', [VisitorsController::class, 'ReadFitur']);