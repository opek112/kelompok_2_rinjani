<?php
use Illuminate\Support\Facades\Route;
use Modules\Rental\Http\Controllers\EquipmentController;

Route::apiResource('equipments', EquipmentController::class);
