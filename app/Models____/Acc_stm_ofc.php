<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
use Illuminate\Contracts\Auth\MustVerifyEmail; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acc_stm_ofc extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acc_stm_ofc'; 
    protected $fillable = [
        'acc_stm_ofc_id',
        'repno',  
        'no', 
        'hn', 
        'an',
        'cid',
        'fullname', 
        'vstdate',
        'dchdate',
        'PROJCODE',
        'AdjRW',
        'price_req',
        'prb',
        'room',
        'inst',
        'drug',
        'income',
        'refer',
        'waitdch',
        'service',
        'pricereq_all',
        'STMdoc',
        'active'
    ];
    public $timestamps = false;   
}
