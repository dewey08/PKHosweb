<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Account_monthlydebt extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'account_monthlydebt';
    protected $primaryKey = 'account_monthlydebt_id';
    protected $fillable = [
        'account_monthlydebt_date', 
        'account_monthlydebt_year'      
    ];

  
}
