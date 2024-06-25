<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Dashboard_department_authen extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'dashboard_department_authen';
    protected $primaryKey = 'dashboard_department_authen_id';
    protected $fillable = [
        'vstdate', 
        'main_dep', 
        'department',  
        'vn',
        'claimCode', 
        'Success',
        'Unsuccess',
           
    ];

  
}
