<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Fdh_ipd extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql';
    protected $table = 'fdh_ipd';
    protected $primaryKey = 'fdh_ipd_id';
    protected $fillable = [
        'HN','AN','DATEADM','TIMEADM','DATEDSC','TIMEDSC','DISCHS'    
    ];

  
}
