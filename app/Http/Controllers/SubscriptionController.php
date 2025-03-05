<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Subscription;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Subscription as StripeSubscription;
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
        Stripe::setApiKey(config('services.stripe.secret'));

        $session_id = $request->query('session_id');

        if (!$session_id) {
            return redirect()->route('services.index')->with('error', 'Invalid session ID');
        }

        // Recupera detalhes da sessão de checkout
        $session = Session::retrieve($session_id);

        // Recupera detalhes da assinatura do Stripe
        $stripeSubscription = StripeSubscription::retrieve($session->subscription);

        $user = Auth::user();
        $service = Service::where('name', $session->line_items->data[0]->description)->first();

        if (!$service) {
            return redirect()->route('services.index')->with('error', 'Service not found.');
        }

        // Salva a assinatura no banco de dados
        Subscription::create([
            'user_id' => $user->id,
            'service_id' => $service->id,
            'stripe_subscription_id' => $stripeSubscription->id,
            'stripe_status' => $stripeSubscription->status,
            'expires_at' => now()->addMonth(), // Assumindo que seja mensal
        ]);

        return redirect()->route('services.index')->with('success', 'Subscription successful!');
    }

    public function cancel()
    {
        return redirect()->route('services.index')->with('error', 'Subscription canceled.');
    }
}
