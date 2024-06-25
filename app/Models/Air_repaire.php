<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Air_repaire extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'air_repaire';
    protected $primaryKey = 'air_repaire_id';
    protected $fillable = [
        'repaire_date',
        'air_list_id', 
    ];

  
}
