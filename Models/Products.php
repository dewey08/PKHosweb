<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Products extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'product_data';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_code',
        'product_name',
        'product_attribute',
        'product_spyprice',
        'product_type',
        'product_group',
        'product_unit_bigname',
        'product_unit_subname'
      
    ];

  
}
