<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Com_repaire extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'com_repaire';
    protected $primaryKey = 'com_repaire_id';
    protected $fillable = [
        'com_repaire_no', 
        'com_repaire_year', 
        'com_repaire_speed',  
        'com_repaire_rate',      
    ];

  
}
