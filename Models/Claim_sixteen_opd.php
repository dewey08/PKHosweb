<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Claim_sixteen_opd extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql7';
    protected $table = 'claim_sixteen_opd';
    protected $primaryKey = 'claim_sixteen_opd_id';
    protected $fillable = [
        'HN', 
        'CLINIC', 
        'DATEOPD',  
        'TIMEOPD',  
        'SEQ',
        'UUC'    
    ];

  
}
