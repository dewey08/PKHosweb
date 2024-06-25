<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Car_type extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'car_type';
    protected $primaryKey = 'car_type_id';
    protected $fillable = [
        'car_type_code', 
        'car_type_name'       
    ];

  
}
