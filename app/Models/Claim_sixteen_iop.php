<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Claim_sixteen_iop extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql7';
    protected $table = 'claim_sixteen_iop';
    protected $primaryKey = 'claim_sixteen_iop_id';
    protected $fillable = [
        'HN', 
        'AN', 
        'DATEIN',  
        'TIMEIN',  
        'DATEOUT',
        'TIMEOUT',
        'OPER', 
        'OPTYPE', 
        'DROPID' 
    ];

  
}
