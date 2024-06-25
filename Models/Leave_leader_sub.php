<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Leave_leader_sub extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'leave_leader_sub';
    protected $primaryKey = 'leave_sub_id';
    protected $fillable = [
        'leader_id',
        'leader_name',
        'user_id',
        'user_name'
    ];

  
}
