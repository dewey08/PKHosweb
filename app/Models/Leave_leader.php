<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Leave_leader extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'leave_leader';
    protected $primaryKey = 'leave_id';
    protected $fillable = [
        'leader_id',
        'leader_name'
    ];

  
}
