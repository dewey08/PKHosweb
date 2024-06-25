<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Six_temp extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $connection = 'mysql7';
    protected $table = 'six_temp';
    protected $primaryKey = 'six_temp_id';
    protected $fillable = [  
        'status',  
        'vn',  
        'hn',
        'an', 
        'cid', 
        'fullname' 
    ];

  
}
