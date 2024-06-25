<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Account_main extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'account_main';
    protected $primaryKey = 'account_main_id';
    protected $fillable = [
        'account_main_date', 
        'account_main_year'      
    ];

  
}
