<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Leave_month_year extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'leave_month_year';
    protected $primaryKey = 'month_year_id';
    protected $fillable = [
        'month_year_code',
        'month_year_name'
    ];

  
}
