<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_hpv_report extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'd_hpv_report';
    protected $primaryKey = 'd_hpv_report_id';
    protected $fillable = [
        'vn',
        'hn',
        'cid'         
    ];

  
}
