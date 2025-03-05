<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Subscription;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function checkout(Service $service)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $user = Auth::user();

        $session = Session::create([
            'payment_method_types' => ['card'],
            'customer_email' => $user->email,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $service->name,
                    ],
                    'unit_amount' => $service->price * 100, // Stripe usa centavos
                    'recurring' => ['interval' => 'month'], // Cobrança mensal
                ],
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' => route('subscription.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('subscription.cancel'),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        return view('subscriptions.success');
    }

    public function cancel()
    {
        return view('subscriptions.cancel');
    }
}
