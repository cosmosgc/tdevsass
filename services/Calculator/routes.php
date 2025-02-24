<?php
use Illuminate\Support\Facades\Route;
use Services\Calculator\Controllers\CalculatorController;

Route::prefix('calculator')->group(function () {
    Route::get('/', [CalculatorController::class, 'index']);
    Route::post('/calculate', [CalculatorController::class, 'calculate']);
});
