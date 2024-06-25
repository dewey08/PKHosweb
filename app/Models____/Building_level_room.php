<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Building_level_room extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'building_level_room';
    protected $primaryKey = 'room_id';
    protected $fillable = [
        'room_name',
        'building_level_id', 
       
    ];

  
}
