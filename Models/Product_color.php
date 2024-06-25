<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Product_color extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'product_color';
    protected $primaryKey = 'color_id';
    protected $fillable = [
        'color_name',
               
    ];

  
}
