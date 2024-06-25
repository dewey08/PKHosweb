<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Check_sithos_auto extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $connection = 'mysql3';
    protected $table = 'check_sithos_auto';
    protected $primaryKey = 'check_sit_auto_id';
    protected $fillable = [  
        'vn',
        'hn',  
        'cid', 
        'vstdate',
        'vsttime',
        'pttype',
        'fullname',
        'staff'
    ];

  
}
