<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeCheckoutController extends Controller
{
    public function checkout()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Produto Exemplo',
                    ],
                    'unit_amount' => 5000, // $50.00 (valor em centavos)
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel'),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        return view('stripe.success');
    }

    public function cancel()
    {
        return view('stripe.cancel');
    }
}
