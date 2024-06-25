<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Check_authen_new extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    // protected $connection = 'mysql2';
    protected $table = 'check_authen_new';
    protected $primaryKey = 'check_authen_new_id';
    protected $fillable = [  
        'hcode',
        'hosname',  
        
    ];

  
}
