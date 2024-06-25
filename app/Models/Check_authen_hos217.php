<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Check_authen_hos217 extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $connection = 'mysql2';
    protected $table = 'check_authen_hos';
    protected $primaryKey = 'check_authen_id';
    protected $fillable = [  
        'hcode',
        'hosname',  
        'cid', 
        'fullname',
        'birthday',
        'homtel',
        'mainpttype',
        'subpttype',
        'repcode',
        'claimcode',
        'claimtype',
        'servicerep',
        'servicename',
        'hncode',
        'ancode',
        'vstdate',
        'regdate',
        'status',
        'requestauthen',
        'authentication',
        'staff_service',
        'date_editauthen',
        'name_editauthen',
        'comment' 
    ];

  
}
