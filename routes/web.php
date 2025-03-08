<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Service;
use App\Services\ServiceLoader;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/services', function () {
    $services = Service::where('active', true)->get();
    return view('services.index', compact('services'));
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\ServiceController;

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

use App\Http\Controllers\StripeCheckoutController;

Route::get('/checkout', [StripeCheckoutController::class, 'checkout'])->name('stripe.checkout');
Route::get('/checkout/success', [StripeCheckoutController::class, 'success'])->name('stripe.success');
Route::get('/checkout/cancel', [StripeCheckoutController::class, 'cancel'])->name('stripe.cancel');

use App\Http\Controllers\SubscriptionController;

Route::middleware(['auth'])->group(function () {
    Route::post('/subscribe/{service}', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');
    Route::get('/subscribe/success', [SubscriptionController::class, 'success'])->name('subscription.success');
    Route::get('/subscribe/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
    Route::post('/subscribe/{service}/{user}', [SubscriptionController::class, 'subscribeUser'])
        ->name('subscription.subscribeUser');
});

use App\Http\Controllers\StripeWebhookController;

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);


ServiceLoader::loadServiceRoutes();

require __DIR__.'/auth.php';
