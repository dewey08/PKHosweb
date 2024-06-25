<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acc_debtor_sendmoney extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acc_debtor_sendmoney';
    protected $primaryKey = 'acc_debtor_sendmoney_id';
    protected $fillable = [
        'send_vn',
        'send_an',
        'send_hn'         
    ];

  
}
