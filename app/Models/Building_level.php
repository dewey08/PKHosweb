<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Building_level extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'building_level';
    protected $primaryKey = 'building_level_id';
    protected $fillable = [
        'building_level_name',
        'building_id',
       
    ];

  
}
