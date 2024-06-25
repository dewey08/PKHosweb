<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Users_prefix extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users_prefix';
    protected $primaryKey = 'prefix_id';
    protected $fillable = [
        'prefix_code',
        'prefix_name'
    ];

  
}
