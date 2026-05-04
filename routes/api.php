<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DemoApiController;

Route::prefix('evaluaciones')->group(function () {
    Route::post('{evaluacion}/start', [DemoApiController::class, 'start']);
});

Route::post('intentos', [DemoApiController::class, 'submitAttempt']);

Route::get('users/{user}/scores', [DemoApiController::class, 'userScores']);
