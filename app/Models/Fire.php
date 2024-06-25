<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Fire extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'fire';
    protected $primaryKey = 'fire_id';
    protected $fillable = [
        'fire_num',
        'fire_name',
        'fire_size'         
    ];

  
}
