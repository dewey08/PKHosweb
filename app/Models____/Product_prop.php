<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Product_prop extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'product_prop';
    protected $primaryKey = 'prop_id';
    protected $fillable = [
        'type_id',
        'prop_name',
        'prop_code',
        'unit_name',
        'active',
        'group_class_code',
        'type_code',
        'group_code',
        'fsn',

            
    ];

  
}
