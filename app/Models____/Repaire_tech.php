<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Repaire_tech extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'repaire_tech';
    protected $primaryKey = 'repaire_tech_id';
    protected $fillable = [
        'repaire_tech_user_id', 
        'repaire_tech_user_name', 
        'repaire_tech_user_position'     
    ];

  
}
