<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Product_group extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'product_group';
    protected $primaryKey = 'product_group_id';
    protected $fillable = [
        'product_group_name',
        'product_group_detail'           
    ];

  
}
