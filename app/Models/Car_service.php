<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Car_service extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'car_service';
    protected $primaryKey = 'car_service_id';
    protected $fillable = [
        'car_service_speed', 
        'car_service_article_id', 
        'car_service_register',  
        'car_service_rate', 
        'car_service_mikenumber_befor',
        'car_service_mikenumber_after',
        'car_service_length_godate',
        'car_service_length_gotime'
    ];

  
}
