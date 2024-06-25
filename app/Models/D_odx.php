<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_odx extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql';
    protected $table = 'd_odx';
    protected $primaryKey = 'd_odx_id';
    protected $fillable = [ 
        'HN', 
        'DATEDX',  
        'CLINIC',  
        'DIAG',
        'DXTYPE',
        'DRDX',  
        'PERSON_ID', 
        'SEQ' 
    ];

  
}
