<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;







Route::group(['prefix'=>'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix'=>'cabinet'], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/users/my', [UserController::class, 'profile']);
        Route::apiResource('users',UserController::class)->only(['index','store','show','destroy']);
        Route::get('/articles', [UserController::class, 'getArticles']);
        Route::apiResource('/articles',ArticleController::class)->except(['index']);
    });
});

