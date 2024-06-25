<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_fdh extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; 
    protected $table = 'd_fdh';
    protected $primaryKey = 'd_fdh_id';
    protected $fillable = [ 
        'vn',  
        'hn',   
    ];
    public $timestamps = false; 
  
}
