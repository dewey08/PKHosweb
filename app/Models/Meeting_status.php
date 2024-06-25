<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Meeting_status extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'meeting_status';
    protected $primaryKey = 'meeting_status_id';
    protected $fillable = [
        'meeting_status_code' ,
        'meeting_status_name'  
    ];

  
}
