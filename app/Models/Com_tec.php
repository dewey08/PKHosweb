<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Com_tec extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'com_tec';
    protected $primaryKey = 'com_tec_id';
    protected $fillable = [
        'com_tec_user_id', 
        'com_tec_user_name', 
        'com_tec_user_position'     
    ];

  
}
