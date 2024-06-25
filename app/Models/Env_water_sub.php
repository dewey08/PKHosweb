<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Env_water_sub extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'env_water_sub';
    protected $primaryKey = 'water_sub_id';
    // public $timestamps = false;  
    protected $fillable = [
        'water_id',
        'water_list_detail',
        'water_list_unit',
        'water_qty',
        'water_results',
        'water_list_idd'        
        
        
    ];

  
}
