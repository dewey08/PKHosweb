<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Market_product_repsub extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'market_product_repsub';
    protected $primaryKey = 'request_sub_id';
    protected $fillable = [
        'request_id',
        'request_sub_product_id',
        'request_sub_product_code',
        'request_sub_product_name', 
      
    ];

  
}
