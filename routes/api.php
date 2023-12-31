<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OutlayController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth:api'])->group(function () {
    Route::apiResources([
        'outlay' => OutlayController::class,
        'user' => UserController::class,
    ]);
});

