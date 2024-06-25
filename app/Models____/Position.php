<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Position extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'position';
    protected $primaryKey = 'POSITION_ID';
    protected $fillable = [
        'POSITION_NAME',
        'POSITION_CHECK_HOLIDAY'
    ];

  
}
