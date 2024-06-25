<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class d_adp extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $connection = 'mysql7';
    protected $table = 'd_adp';
    protected $primaryKey = 'd_adp_id';
    protected $fillable = [ 
        'HN', 
        'AN',  
        'DATEOPD',  
        'TYPE',
        'CODE',
        'QTY', 
        'RATE', 
        'SEQ', 
        'a1', 
        'a2', 
        'a3', 
        'a4', 
        'a5', 
        'a6', 
        'a7', 
        'TMLTCODE', 
        'STATUS1', 
        'BI',     
        'CLINIC',
        'ITEMSRC',
        'PROVIDER',
        'GLAVIDA',
        'GA_WEEK',
        'DCIP',
        'LMP',
    ];

  
}
