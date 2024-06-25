<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Car_status extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'car_status';
    protected $primaryKey = 'car_status_id';
    protected $fillable = [
        'car_status_code', 
        'car_status_name'       
    ];

  
}
