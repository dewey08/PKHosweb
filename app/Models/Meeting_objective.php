<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Meeting_objective extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'meeting_objective';
    protected $primaryKey = 'meeting_objective_id';
    protected $fillable = [
        'meeting_objective_name'  
    ];

  
}
