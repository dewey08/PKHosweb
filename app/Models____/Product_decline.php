<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Product_decline extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'product_decline';
    protected $primaryKey = 'decline_id';
    protected $fillable = [
        'decline_name',
        'old_year',
        'decline_userid',
        'cod_ref'      
    ];

  
}
