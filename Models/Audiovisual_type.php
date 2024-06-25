<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Audiovisual_type extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // protected $connection = 'mysql7';
    protected $table = 'audiovisual_type';
    protected $primaryKey = 'audiovisual_type_id';
    protected $fillable = [ 
        'audiovisual_typename',  
        'audiovisual_type_active',   
    ];
    public $timestamps = false; 
  
}
