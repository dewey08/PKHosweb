<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Aipn_ipop extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $connection = 'mysql7';
    protected $table = 'aipn_ipop';
    protected $primaryKey = 'aipn_ipop_id';
    protected $fillable = [  
        'an',  
        'sequence',  
    ];

  
}
