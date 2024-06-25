<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Dashboard_authenstaff_day extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'dashboard_authenstaff_day';
    protected $primaryKey = 'dashboard_authenstaff_day_id';
    protected $fillable = [
        'vstdate', 
        'Staff', 
        'Spclty',  
        'vn',
        'claimCode', 
        'Success',
        'Unsuccess',
           
    ];

  
}
