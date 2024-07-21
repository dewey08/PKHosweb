<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Env_pond_sub extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'env_pond_sub';
    protected $primaryKey = 'pond_sub_id';
    // public $timestamps = false;  
    protected $fillable = [
        'pond_id',
        'pond_name',
        'water_parameter_id',
        'water_parameter_name',
        'water_parameter_short_name',
        'water_parameter_unit'
        // 'trash_set_unit'
              
    ];

  
}
