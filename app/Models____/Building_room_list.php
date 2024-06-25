<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Building_room_list extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'building_room_list';
    protected $primaryKey = 'room_list_id';
    protected $fillable = [
        'room_list_name',
        'room_list_qty', 
        'room_id',
    ];

  
}
