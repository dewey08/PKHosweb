<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Product_unit extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'product_unit';
    protected $primaryKey = 'unit_id';
    protected $fillable = [
        'unit_name',
        'active'           
    ];

  
}
