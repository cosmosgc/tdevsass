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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function isActive()
    {
        return $this->stripe_status === 'active' && $this->expires_at > Carbon::now();
    }
}
