<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
use Illuminate\Contracts\Auth\MustVerifyEmail; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acc_stm_ti extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acc_stm_ti'; 
    protected $fillable = [
        'acc_stm_ti_id',
        'repno',
        'tranid',
        'hn',
        'cid',
        'fullname',
        'subinscl',
        'vstdate',
        'regdate',
        'type_req',
        'price_req',
        'price_approve',
        'price_approve_no',
        'comment',
        'date_save',
        'vn',
        'active' 
    ];
    public $timestamps = false; 

  
}
