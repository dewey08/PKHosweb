<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_aipn_session extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // protected $connection = 'mysql7';
    protected $table = 'd_aipn_session';
    protected $primaryKey = 'd_aipn_session_id';
    protected $fillable = [ 
        'aipn_session_no', 
        'aipn_session_date',  
        'aipn_session_time',   
    ];
    public $timestamps = false; 
  
}
