<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class P4p_dayoff extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'p4p_dayoff';
    protected $primaryKey = 'p4p_dayoff_id';
    protected $fillable = [
        'date_holiday',
        'date_detail'
      
    ];

  
}
