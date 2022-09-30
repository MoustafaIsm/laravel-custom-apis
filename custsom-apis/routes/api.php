<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\controllers\FirstController;

Route::get("/first_api/{randomString}", [FirstController::class, 'sortString']);

Route::get("/second_api/{num}", [FirstController::class, 'getNumberPlacements']);

Route::get("/third_api/{string}", [FirstController::class, 'transformHumanToRobot']);

Route::get("/fourth_api/{prefixNotation}", [FirstController::class, 'solveNotation']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
