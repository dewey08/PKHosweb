<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Car_drive extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'car_drive';
    protected $primaryKey = 'car_drive_id';
    protected $fillable = [
        'car_drive_user_id', 
        'car_drive_user_name', 
        'car_drive_user_position'      
    ];

  
}
