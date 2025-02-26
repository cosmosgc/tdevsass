<?php
namespace Services\SocialScheduler\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduledPost extends Model
{
    protected $fillable = ['user_id','content', 'scheduled_at', 'platforms'];
}
