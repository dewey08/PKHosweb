<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Env_parameter_list extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'env_parameter_list';
    protected $primaryKey = 'parameter_list_id';
    // public $timestamps = false;  
    protected $fillable = [
        'parameter_list_name',
        'parameter_list_unit',
        'parameter_list_normal',
        'parameter_list_user_analysis_results'
        
    ];

  
}
