<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Com_repaire_speed extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'com_repaire_speed';
    protected $primaryKey = 'status_id';
    protected $fillable = [
        'status_name',      
    ];

  
}
