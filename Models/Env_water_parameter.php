<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Env_water_parameter extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'env_water_parameter';
    protected $primaryKey = 'water_parameter_id';
    // public $timestamps = false;  
    protected $fillable = [
        'water_parameter_name',
        'water_parameter_short_name',
        'water_parameter_unit',
        'water_parameter_icon',
        'water_parameter_normal',
        'water_parameter_results',
        'water_parameter_active'   
        
        
    ];

  
}
