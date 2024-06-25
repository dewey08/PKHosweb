<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Ssop_opservices extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $connection = 'mysql';
    protected $table = 'ssop_opservices';
    protected $primaryKey = 'ssop_opservices_id';
    protected $fillable = [  
        'Invno',  
        'SvID',  
        'Class',
        'Hcode', 
        'HN', 
        'PID' 
    ];

  
}
