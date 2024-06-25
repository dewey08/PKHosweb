<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Account_creditor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'account_creditor';
    protected $primaryKey = 'account_creditor_id';
    protected $fillable = [
        'account_creditor_code', 
        'account_creditor_name'      
    ];

  
}
