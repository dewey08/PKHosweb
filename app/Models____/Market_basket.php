<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Market_basket extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'market_basket';
    protected $primaryKey = 'basket_id';
    protected $fillable = [
        'basket_product_id',
        'basket_product_code',
        'basket_product_name',
        'basket_qty',
        'basket_price',
        'basket_sum_price',
        'basket_sub_unitid', 
    ];

  
}
