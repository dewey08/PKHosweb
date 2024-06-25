<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Users_group extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users_group';
    protected $primaryKey = 'users_group_id';
    protected $fillable = [
        'users_group_name',
        'users_group_detail',
        'users_group_leave_qty'
    ];

  
}
