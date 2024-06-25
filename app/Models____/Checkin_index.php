<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Checkin_index extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $connection = 'mysql6';
    protected $table = 'checkin_index';
    protected $primaryKey = 'CHECKIN_ID';
    protected $fillable = [
        'CHECKIN_PERSON_ID', 
        'HR_POSITION_ID', 
        'HR_DEPARTMENT_SUB_SUB_ID'     
    ];

  
}
