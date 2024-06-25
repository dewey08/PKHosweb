<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_rep_eclaim extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // protected $connection = 'mysql7';
    protected $table = 'd_rep_eclaim';
    protected $primaryKey = 'd_rep_eclaim_id';
    protected $fillable = [ 
        'a', 
        'b',  
        'c',   
    ];
    public $timestamps = false; 
  
}
