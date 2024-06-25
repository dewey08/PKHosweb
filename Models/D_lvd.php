<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_lvd extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql';
    protected $table = 'd_lvd';
    protected $primaryKey = 'd_lvd_id';
    protected $fillable = [
        'SEQLVD', 
        'AN', 
        'DATEOUT',  
        'TIMEOUT',  
        'DATEIN',
        'TIMEIN',
        'QTYDAY', 
      
    ];

  
}
