<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Meeting_service extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'meeting_service';
    protected $primaryKey = 'meeting_id';
    protected $fillable = [
        'meetting_title',
        'meeting_date_begin',
        'meeting_date_end',
    ];

  
}
