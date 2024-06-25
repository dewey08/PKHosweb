<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Stm extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $connection = 'mysql7';
    protected $table = 'stm';
    protected $primaryKey = 'ssop_stm_id';
    protected $fillable = [  
        'TRAN_ID', 
        'REPNO',  
        'SN',  
    ];

  
}
