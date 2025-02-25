<?php
namespace Services\SocialScheduler\Models;

use Illuminate\Database\Eloquent\Model;

class SchedulerSetting extends Model
{
    protected $fillable = ['user_id', 'enabled_networks', 'api_keys'];
}
