<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the subscriptions for the user.
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get the services the user is subscribed to.
     */
    public function subscribedServices()
    {
        return $this->belongsToMany(Service::class, 'subscriptions')->withPivot('stripe_status', 'expires_at');
    }

    /**
     * Check if the user is subscribed to a specific service.
     */
    public function isSubscribedTo(Service $service)
    {
        return $this->subscribedServices()
            ->where('service_id', $service->id)
            ->where('stripe_status', 'active')
            ->where('expires_at', '>', now())
            ->exists();
    }
}
