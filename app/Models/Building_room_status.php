<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Building_room_status extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'building_room_status';
    protected $primaryKey = 'room_status_id';
    protected $fillable = [
        'room_status_name' 
    ];

  
}
