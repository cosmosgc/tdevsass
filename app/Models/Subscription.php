<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'stripe_subscription_id',
        'stripe_status',
        'expires_at',
    ];

    /**
     * Get the user who owns this subscription.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the service this subscription belongs to.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Check if the subscription is active.
     */
    public function isActive()
    {
        return $this->stripe_status === 'active' && $this->expires_at > Carbon::now();
    }
}
