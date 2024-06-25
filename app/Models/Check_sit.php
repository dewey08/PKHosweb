<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Check_sit extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $connection = 'mysql8';
    protected $table = 'check_sit';
    protected $primaryKey = 'check_sit_vn';
    public $timestamps = false;  
    protected $fillable = [  
        'check_sit_date',  
        'check_sit_maininscl',  
        'check_sit_subinscl',
        'check_sit_startdate',
        'check_sit_status',
        'check_sit_user_person_id',
        'check_sit_hmain',
        'check_sit_vstdate',
        'check_sit_cid'
    ];

  
}
