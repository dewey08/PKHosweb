<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Market_product extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'market_product';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_code',
        'product_name',
        'product_categoryid',
        'product_categoryname',
        'product_unit_bigid',
        'product_unit_bigname',
        'product_unit_subid',
        'product_unit_subname'
      
    ];

  
}
