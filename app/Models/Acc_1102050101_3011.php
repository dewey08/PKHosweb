<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acc_1102050101_3011 extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acc_1102050101_3011';
    protected $primaryKey = 'acc_1102050101_3011_id';
    protected $fillable = [
        'vn',
        'an',
        'hn'         
    ];

  
}
