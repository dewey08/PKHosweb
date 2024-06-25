<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Products_category extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'product_category';
    protected $primaryKey = 'category_id';
    protected $fillable = [
        'category_name',
        'active'
            
    ];

  
}
