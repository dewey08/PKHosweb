<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Ins_eclaimxxx extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $connection = 'mysql7';
    protected $table = 'ins_eclaimxxx';
    protected $primaryKey = 'ins_eclaimxxx_id';
    protected $fillable = [ 
        'hipdata', 
        'icodex' 
    ];

  
}
