<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
use Illuminate\Contracts\Auth\MustVerifyEmail; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acc_stm_ti_excel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acc_stm_ti_excel'; 
    protected $fillable = [
        'acc_stm_ti_excel_id',
        'repno', 
        'tranid',
        'hn', 
        'an',
        'cid',
        'fullname',
        'hipdata_code',
        'hcode',
        'regdate',
        'vstdate',
        'no',
        'list',
        'qty',
        'unitprice',
        'unitprice_max',
        'price_request',
        'pscode',
        'percent',
        'pay_amount',
        'nonpay_amount',
        'payplus_amount',
        'payback_amount',
        'active',
        'filename'
    ];
    public $timestamps = false;   
}
