<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Users_kind_type extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users_kind_type';
    protected $primaryKey = 'users_kind_type_id';
    protected $fillable = [
        'users_kind_type_name', 
    ];

  
}
