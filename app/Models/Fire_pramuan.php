<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Fire_pramuan extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'fire_pramuan';
    protected $primaryKey = 'fire_pramuan_id';
    protected $fillable = [ 
        'fire_pramuan_name',      
    ];

  
}
