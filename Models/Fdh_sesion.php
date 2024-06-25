<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Fdh_sesion extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'fdh_sesion';
    protected $primaryKey = 'fdh_sesion_id';
    protected $fillable = [ 
        'folder_name', 
        'd_anaconda_id',  
        'date_save',      
    ];

  
}
