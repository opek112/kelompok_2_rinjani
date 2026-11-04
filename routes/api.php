<?php

use App\Http\Controllers\Api\EquipmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/equipments', [EquipmentController::class, 'index']);
Route::post('/equipments', [EquipmentController::class, 'store']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
