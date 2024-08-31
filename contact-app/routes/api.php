<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function () {
    return ['Deu certo' => "Opa"];
});

Route::get('/user', [UserController::class, 'index']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::post('/user', [UserController::class, 'store']);
Route::put('user/{id}', [UserController::class, 'update']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);

Route::get('/contact', [ContactController::class, 'index']);
Route::get('/contact/{id}', [ContactController::class, 'show']);
Route::post('/contact', [ContactController::class, 'store']);
Route::put('contact/{id}', [ContactController::class, 'update']);
Route::delete('/contact/{id}', [ContactController::class, 'destroy']);