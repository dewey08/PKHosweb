<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Check_sit_tiauto extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    // protected $connection = 'mysql7';
    protected $table = 'check_sit_tiauto';
    protected $primaryKey = 'check_sit_tiauto_id';
    protected $fillable = [  
        'vn',
        'hn',  
        'cid', 
        'vstdate', 
    ];

  
}
