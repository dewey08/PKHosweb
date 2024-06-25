<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Ssop_stm_claim extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $connection = 'mysql7';
    protected $table = 'ssop_stm_claim';
    protected $primaryKey = 'ssop_stm_claim_id';
    protected $fillable = [  
        'vn' 
    ];

  
}
