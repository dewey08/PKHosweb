<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_pat extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql7';
    protected $table = 'd_pat';
    protected $primaryKey = 'd_pat_id';
    protected $fillable = [ 
        'HCODE', 
        'HN',  
        'CHANGWAT',  
        'AMPHUR',
        'DOB', 
        'SEX', 
        'MARRIAGE',
        'OCCUPA',
        'NATION',
        'PERSON_ID',
        'NAMEPAT',
        'TITLE',
        'FNAME',
        'LNAME',
        'IDTYPE'
    ];

  
}
