<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_aipop extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // protected $connection = 'mysql7';
    protected $table = 'd_aipop';
    protected $primaryKey = 'd_aipop_id';
    protected $fillable = [ 
        'sequence', 
        'an',  
        'CodeSys',   
    ];
    public $timestamps = false; 
  
}
