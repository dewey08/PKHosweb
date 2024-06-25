<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_ucep24 extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // protected $connection = 'mysql7';
    protected $table = 'd_ucep24';
    protected $primaryKey = 'd_ucep24_id';
    protected $fillable = [ 
        'vn', 
        'an',  
        'hn',  
        'vstdate' 
    ];
    public $timestamps = false; 
  
}
