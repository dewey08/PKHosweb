<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Car_service_personjoin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'car_service_personjoin';
    protected $primaryKey = 'car_service_personjoin_id';
    protected $fillable = [
        'car_service_id', 
        'person_join_id', 
        'person_join_name'      
    ];

  
}
