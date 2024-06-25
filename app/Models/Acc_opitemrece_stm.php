<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acc_opitemrece_stm extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acc_opitemrece_stm';
    protected $primaryKey = 'acc_opitemrece_stm_id';
    protected $fillable = [
        'vn',
        'an',
        'hn'         
    ];

  
}
