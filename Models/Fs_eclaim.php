<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Fs_eclaim extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $connection = 'mysql7';
    protected $table = 'fs_eclaim';
    protected $primaryKey = 'fs_eclaim_id';
    protected $fillable = [ 
        'num', 
        'billcode',
        'dname'
    ];

  
}
