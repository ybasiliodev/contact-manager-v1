<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return ['Deu certo' => "Opa"];
});

Route::group(['prefix' => 'v1'], function () {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/user', [UserController::class, 'store']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/user', [UserController::class, 'index']);
        Route::get('/user/{id}', [UserController::class, 'show']);
        Route::put('user/{id}', [UserController::class, 'update']);
        Route::delete('/user/{id}', [UserController::class, 'destroy']);

        Route::get('/contact', [ContactController::class, 'index']);
        Route::get('/contact/{id}', [ContactController::class, 'show']);
        Route::post('/contact', [ContactController::class, 'store']);
        Route::put('contact/{id}', [ContactController::class, 'update']);
        Route::delete('/contact/{id}', [ContactController::class, 'destroy']);
    });
});