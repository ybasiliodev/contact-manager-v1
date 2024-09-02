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

        Route::group(['prefix' => 'user'], function () {
            Route::delete('/', [UserController::class, 'destroy']);
            Route::post('/logout', [UserController::class, 'logout']);
        });

        Route::get('contact/list', [ContactController::class, 'showByUser']);

        Route::group(['prefix' => 'contact'], function () {
            Route::get('/{id}', [ContactController::class, 'show']);
            Route::post('/', [ContactController::class, 'store']);
            Route::put('/{id}', [ContactController::class, 'update']);
            Route::delete('/{id}', [ContactController::class, 'destroy']);
        });

        Route::group(['prefix' => 'geo'], function () {
            Route::get('/locate/{postal_code}', [GeoController::class, 'showAddress']);
            Route::get('/cordinates', [GeoController::class, 'showCordinates']);
            Route::get('/map', [GeoController::class, 'showMap']);
        });
    });
});