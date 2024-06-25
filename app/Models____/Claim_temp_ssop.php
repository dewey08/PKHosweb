<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Claim_temp_ssop extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $connection = 'mysql7';
    protected $table = 'claim_temp_ssop';
    protected $primaryKey = 'claim_temp_ssop_id';
    protected $fillable = [  
        'HN',  
        'AN',  
        'SEQ',
        'CID', 
        'CHECK', 
        'STATUS' 
    ];

  
}
