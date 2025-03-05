<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Webhook;
use App\Models\Subscription;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $event = $request->all();

        if ($event['type'] === 'invoice.payment_succeeded') {
            $subscriptionId = $event['data']['object']['subscription'];
            $subscription = Subscription::where('stripe_subscription_id', $subscriptionId)->first();

            if ($subscription) {
                $subscription->update([
                    'stripe_status' => 'active',
                    'expires_at' => now()->addMonth(),
                ]);
            }
        } elseif ($event['type'] === 'customer.subscription.deleted') {
            $subscriptionId = $event['data']['object']['id'];
            $subscription = Subscription::where('stripe_subscription_id', $subscriptionId)->first();

            if ($subscription) {
                $subscription->update(['stripe_status' => 'canceled']);
            }
        }

        return response()->json(['status' => 'success']);
    }
}
