<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Ssop_opdx extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $connection = 'mysql';
    protected $table = 'ssop_opdx';
    protected $primaryKey = 'ssop_opdx_id';
    protected $fillable = [  
        'Class',  
        'SvID',  
        'SL',
        'CodeSet', 
        'code', 
        'Desc' 
    ];

  
}
