<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class F_finance_opd extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    // protected $connection = 'mysql2';
    protected $table = 'f_finance_opd';
    protected $primaryKey = 'f_finance_opd_id';
    protected $fillable = [  
        'year',
        'months',  
        
    ];

  
}
