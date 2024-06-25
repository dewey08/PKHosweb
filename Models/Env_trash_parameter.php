<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Env_trash_parameter extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'env_trash_parameter';
    protected $primaryKey = 'trash_parameter_id';
    // public $timestamps = false;  
    protected $fillable = [
        'trash_parameter_name',
        'trash_parameter_unit',
        'trash_parameter_active'
        // 'parameter_list_user_analysis_results'
    ];

  
}
