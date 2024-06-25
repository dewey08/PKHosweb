<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Env_vendor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'env_vendor';
    protected $primaryKey = 'env_vendor_id';
    // public $timestamps = false;  
    protected $fillable = [
        'env_vendor_name',
        'env_vendor_phone',
        'env_vendor_address',
        'env_vendor_tax'
              
    ];

  
}
