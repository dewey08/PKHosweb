<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Air_list extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'air_list';
    protected $primaryKey = 'air_list_id';
    protected $fillable = [
        'air_list_num',
        'air_list_name', 
    ];

  
}
