<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Line_token extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'line_token';
    protected $primaryKey = 'line_token_id';
    protected $fillable = [
        'line_token_name', 
        'line_token_code'       
    ];

  
}
