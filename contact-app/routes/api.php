<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GeoController;

Route::group(['prefix' => 'v1'], function () {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/user', [UserController::class, 'store']);
    Route::post('/recover', [UserController::class, 'recover']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::delete('/user', [UserController::class, 'destroy']);
        Route::post('/user/logout', [UserController::class, 'logout']);

        Route::get('/contact', [ContactController::class, 'index']);
        Route::get('/contact/{id}', [ContactController::class, 'show']);
        Route::get('/my-list', [ContactController::class, 'showByUser']);
        Route::post('/contact', [ContactController::class, 'store']);
        Route::put('/contact/{id}', [ContactController::class, 'update']);
        Route::delete('/contact/{id}', [ContactController::class, 'destroy']);

        Route::group(['prefix' => 'geo'], function () {
            Route::get('/locate/{postal_code}', [GeoController::class, 'showAddress']);
            Route::get('/cordinates', [GeoController::class, 'showCordinates']);
            Route::get('/map', [GeoController::class, 'showMap']);
        });
    });
});