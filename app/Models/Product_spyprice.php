<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Product_spyprice extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'product_spyprice';
    protected $primaryKey = 'spyprice_id';
    protected $fillable = [
        'spyprice_name'            
    ];

  
}
