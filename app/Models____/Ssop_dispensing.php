<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Ssop_dispensing extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $connection = 'mysql7';
    protected $table = 'ssop_dispensing';
    protected $primaryKey = 'ssop_dispensing_id';
    protected $fillable = [  
        'ProviderID',  
        'DispID',  
        'Invno',
        'HN', 
        'PID', 
        'Prescdt' 
    ];

  
}
