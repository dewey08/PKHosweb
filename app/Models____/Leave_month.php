<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Leave_month extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'leave_month';
    protected $primaryKey = 'MONTH_ID';
    protected $fillable = [
        'MONTH_NAME',
        'MONTH_NAME_EN'
    ];

  
}
