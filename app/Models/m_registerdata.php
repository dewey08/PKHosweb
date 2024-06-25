<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class m_registerdata extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'm_registerdata';
    protected $primaryKey = 'ECLAIM_NO';
    protected $fillable = [
        'HCODE' ,
        'HN' ,
        'AN'      
    ];

  
}
