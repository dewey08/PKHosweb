<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_opd extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql7';
    protected $table = 'd_opd';
    protected $primaryKey = 'd_opd_id';
    protected $fillable = [
        'HN', 
        'CLINIC', 
        'DATEOPD',  
        'TIMEOPD',  
        'SEQ',
        'UUC'    
    ];

  
}
