<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Account_listpercen extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'account_listpercen';
    protected $primaryKey = 'account_listpercen_id';
    protected $fillable = [
        'account_listpercen_name', 
        'account_listpercen_percent',
        'account_listpercen_active'      
    ];

  
}
