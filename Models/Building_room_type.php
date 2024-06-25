<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Building_room_type extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'building_room_type';
    protected $primaryKey = 'room_type_id';
    protected $fillable = [
        'room_type_name' 
    ];

  
}
