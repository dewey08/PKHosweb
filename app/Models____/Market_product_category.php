<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Market_product_category extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'market_product_category';
    protected $primaryKey = 'category_id';
    protected $fillable = [
        'category_name', 
    ];

  
}
