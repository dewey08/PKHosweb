<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Account_percen extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'account_percen';
    protected $primaryKey = 'account_percen_id';
    protected $fillable = [
        'account_percen_code', 
        'account_percen_name',
        'account_percen_percent'      
    ];

  
}
