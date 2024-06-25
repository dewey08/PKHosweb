<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acc_debtor_stamp extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acc_debtor_stamp';
    protected $primaryKey = 'acc_debtor_stamp_id';
    protected $fillable = [
        'stamp_vn',
        'stamp_an',
        'stamp_hn'         
    ];

  
}
