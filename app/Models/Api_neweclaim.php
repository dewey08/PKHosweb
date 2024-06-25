<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Api_neweclaim extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'api_neweclaim';
    protected $primaryKey = 'api_neweclaim_id';
    protected $fillable = [
        'api_neweclaim_user',
        'api_neweclaim_pass',
        'api_neweclaim_token'
    ];

}
