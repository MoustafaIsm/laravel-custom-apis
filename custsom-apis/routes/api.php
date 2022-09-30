<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\controllers\FirstController;

Route::get("/first_api/{randomString}", [FirstController::class, 'sortString']);

Route::get("/second_api/{num}", [FirstController::class, 'getNumberPlacements']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
