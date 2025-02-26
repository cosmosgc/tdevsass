<?php
use Illuminate\Support\Facades\Route;
use Services\SocialScheduler\Controllers\SocialSchedulerController;

Route::prefix('social-scheduler')->group(function () {
    Route::get('/', [SocialSchedulerController::class, 'index']);
    Route::post('/store', [SocialSchedulerController::class, 'store']);
    Route::get('/settings', [SocialSchedulerController::class, 'settings']);
    Route::post('/settings/save', [SocialSchedulerController::class, 'saveSettings']);

    // Rotas para postar em cada rede social
    Route::post('/post/facebook', [SocialSchedulerController::class, 'postToFacebook'])->name('social.post.facebook');
    Route::post('/post/twitter', [SocialSchedulerController::class, 'postToTwitter'])->name('social.post.twitter');
    Route::post('/post/wordpress', [SocialSchedulerController::class, 'postToWordPress'])->name('social.post.wordpress');

    // Rota para forçar post AGORA
    Route::post('/post/now/{post}', [SocialSchedulerController::class, 'postNow'])->name('social.post.now');

});
