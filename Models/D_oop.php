<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_oop extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql';
    protected $table = 'd_oop';
    protected $primaryKey = 'd_oop_id';
    protected $fillable = [ 
        'HN', 
        'DATEOPD',  
        'CLINIC',  
        'OPER',
        'DROPID',
        'PERSON_ID',  
        'SEQ' 
    ];

  
}
