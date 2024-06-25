<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Dashboard_authen_day extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'dashboard_authen_day';
    protected $primaryKey = 'dashboard_authen_day_id';
    protected $fillable = [
        'vstdate', 
        'hn', 
        'vn',  
        'cid',
        'Kios', 
        'Kios_success',
        'Staff',
        'Staff_success',
        'Total_Success',
        'Total_Unsuccess'    
    ];

  
}
