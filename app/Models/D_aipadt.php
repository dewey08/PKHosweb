<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_aipadt extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // protected $connection = 'mysql7';
    protected $table = 'd_aipadt';
    protected $primaryKey = 'd_aipadt_id';
    protected $fillable = [ 
        'AN', 
        'HN',  
        'IDTYPE',   
    ];
    public $timestamps = false; 
  
}
