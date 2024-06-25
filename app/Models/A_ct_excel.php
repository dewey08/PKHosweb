<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
use Illuminate\Contracts\Auth\MustVerifyEmail; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class A_ct_excel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'a_ct_excel'; 
    // protected $primaryKey = 'a_ct_excel_id';
    protected $fillable = [ 
        'ct_date', 
        'ct_timein',
        'hn',
        'an',
        'cid',
        'ptname', 
        'sfhname', 
        'typename', 
        'pttypename',
        'hname',
        'cardno',
        'ward',
        'service',
        'icode_hos',
        'ct_check',
        'price_check',
        'total_price_check',
        'opaque',
        'opaque_price',
        'total_opaque_price',
        'other',
        'other_price',
        'total_other_price',
        'before_price',
        'discount',
        'total',
        'sumprice',
        'paid',
        'remain', 
        'doctor',
        'doctor_read',
        'technician' ,
        'technician_sub',
        'nurse',
        'icd9',
        'user_id',
        'STMDoc',
        'vn',
        'hos_check',
        'hos_price_check',
        'hos_total_price_check'
    ];
    // public $timestamps = false; 

  
}
