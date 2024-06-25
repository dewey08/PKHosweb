<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Operate_time extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'operate_time';
    protected $primaryKey = 'operate_time_id';
    protected $fillable = [
        'operate_time_date',
        'operate_time_personid',
        'operate_time_typeid',
        'operate_time_person',
        'operate_time_in',
        'operate_time_out',
        'operate_time_otin',
        'operate_time_otout',
        'totaltime_narmal',
        'totaltime_ot'       
    ];

  
}
