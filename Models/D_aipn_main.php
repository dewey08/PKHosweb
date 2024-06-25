<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_aipn_main extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // protected $connection = 'mysql7';
    protected $table = 'd_aipn_main';
    protected $primaryKey = 'd_aipn_main_id';
    protected $fillable = [ 
        'vn', 
        'an',  
        'hn',   
    ];
    public $timestamps = false; 
  
}
