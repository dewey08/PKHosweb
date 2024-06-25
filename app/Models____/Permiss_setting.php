<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Permiss_setting extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'permiss_setting';
    protected $primaryKey = 'permiss_setting_id';
    protected $fillable = [
        'permiss_setting_userid', 
        'permiss_setting_name'
         
    ];

  
}
