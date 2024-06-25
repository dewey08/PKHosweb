<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Car_index extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'car_index';
    protected $primaryKey = 'car_index_id';
    protected $fillable = [
        'car_index_speed', 
        'car_index_article_id', 
        'car_index_register',  
        'car_index_rate', 
        'car_index_mikenumber_befor',
        'car_index_mikenumber_after',
        'car_index_length_godate',
        'car_index_length_gotime'
    ];

  
}
