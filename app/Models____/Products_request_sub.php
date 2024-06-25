<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Products_request_sub extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'products_request_sub';
    protected $primaryKey = 'request_sub_id';
    protected $fillable = [
        'request_sub_product_id',
        'request_sub_product_code',
        'request_sub_product_name',
        'request_sub_qty',
        'request_sub_unitid',
        'request_sub_unitname'      
        
    ];

  
}
