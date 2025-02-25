<?php
use Illuminate\Support\Facades\Route;
use Services\SocialScheduler\Controllers\SocialSchedulerController;

Route::prefix('social-scheduler')->group(function () {
    Route::get('/', [SocialSchedulerController::class, 'index']);
    Route::post('/store', [SocialSchedulerController::class, 'store']);
});
