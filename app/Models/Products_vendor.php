<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Products_vendor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'products_vendor';
    protected $primaryKey = 'vendor_id';
    protected $fillable = [
        'vendor_name',
        'vendor_phone'           
    ];

  
}
