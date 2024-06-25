<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Fdh_opd extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql';
    protected $table = 'fdh_opd';
    protected $primaryKey = 'fdh_opd_id';
    protected $fillable = [
        'HN', 
        'CLINIC', 
        'DATEOPD',  
        'TIMEOPD',  
        'SEQ',
        'UUC'    
    ];

  
}
