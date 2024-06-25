<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Products_type extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'product_type';
    protected $primaryKey = 'sub_type_id';
    protected $fillable = [
        'sub_type_name',
        'sub_type_master_id',
        'active'
            
    ];

  
}
