<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'active',
        'slug',
    ];

    /**
     * Get the subscriptions for this service.
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get the users subscribed to this service.
     */
    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'subscriptions')->withPivot('stripe_status', 'expires_at');
    }
}
