<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Db_authen extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'db_authen';
    protected $primaryKey = 'db_authen_id';
    protected $fillable = [
        'month', 
        'year', 
        'countvn',  
        'countan',
        'authen_opd', 
        'authen_ipd',
        'authen_user',
        'authen_kios',
        'authen_no'   
    ];

  
}
