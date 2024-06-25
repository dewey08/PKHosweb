<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_ipd extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql7';
    protected $table = 'd_ipd';
    protected $primaryKey = 'd_ipd_id';
    protected $fillable = [
        'HN', 
        'AN', 
        'DATEADM',  
        'TIMEADM',  
        'DATEDSC',
        'TIMEDSC',
        'DISCHS', 
        'DISCHT', 
        'WARDDSC', 
        'DEPT', 
        'ADM_W', 
        'UUC', 
        'SVCTYPE' 
    ];

  
}
