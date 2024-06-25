<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Product_buy extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'product_buy';
    protected $primaryKey = 'buy_id';
    protected $fillable = [
        'buy_name',
        'buy_comment',
        'prixe_min', 
        'price_max'    
    ];

  
}
