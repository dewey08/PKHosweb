<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_12002 extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // protected $connection = 'mysql7';
    protected $table = 'd_12002';
    protected $primaryKey = 'd_12002_id';
    protected $fillable = [ 
        'vn', 
        'an',  
        'hn',   
    ];
    public $timestamps = false; 
  
}
