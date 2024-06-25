<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Pang_stamp_temp extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $connection = 'mysql5';
    protected $table = 'pang_stamp_temp';
    protected $primaryKey = 'pang_stamp_id';
    public $timestamps = false;  
    protected $fillable = [  
        'cid',  
        'vn',  
    ];

  
}
