<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Ot_one extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'ot_one';
    protected $primaryKey = 'ot_one_id';
    protected $fillable = [
        'ot_one_date', 
        'ot_one_starttime', 
        'ot_one_endtime',  
        'ot_one_fullname',      
    ];

  
}
