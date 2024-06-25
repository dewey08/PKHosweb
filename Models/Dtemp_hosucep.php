<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Dtemp_hosucep extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql3';
    protected $table = 'dtemp_hosucep';
    protected $primaryKey = 'dtemp_hosucep_id';
    protected $fillable = [ 
        'an', 
        'hn',  
        'icode',  
        'rxdate' 
    ];

  
}
