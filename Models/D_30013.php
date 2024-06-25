<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_30013 extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // protected $connection = 'mysql7';
    protected $table = 'd_30013';
    protected $primaryKey = 'd_30013_id';
    protected $fillable = [ 
        'vn', 
        'vstdate',  
        'hn',   
    ];
    public $timestamps = false; 
  
}
