<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Ssop_session extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $connection = 'mysql';
    protected $table = 'ssop_session';
    protected $primaryKey = 'ssop_session_id';
    protected $fillable = [  
        'ssop_session_no',  
        'ssop_session_date',  
    ];

  
}
