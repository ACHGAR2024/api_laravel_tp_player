<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PlayerController;
use App\Http\Controllers\API\ClubController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes pour les joueurs (PlayerController)
Route::apiResource('players', PlayerController::class)->only(['index', 'show', 'store', 'update', 'destroy']);

// Routes pour les clubs (ClubController)
Route::apiResource('clubs', ClubController::class)->only(['index', 'store', 'show', 'update', 'destroy']);