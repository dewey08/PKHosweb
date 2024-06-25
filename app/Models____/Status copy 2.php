<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Status extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'status';
    protected $primaryKey = 'STATUS_ID';
    protected $fillable = [
        'STATUS_NAME'
      
    ];

  
}
