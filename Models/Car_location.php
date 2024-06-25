<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Car_location extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'car_location';
    protected $primaryKey = 'car_location_id';
    protected $fillable = [
        'car_location_name'   
    ];

  
}
