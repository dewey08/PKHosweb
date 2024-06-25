<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Plan_control_activity_sub extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'plan_control_activity_sub';
    protected $primaryKey = 'plan_control_activity_sub_id';
    protected $fillable = [
        'plan_control_id',
        'plan_control_activity_id'
      
    ];

  
}
