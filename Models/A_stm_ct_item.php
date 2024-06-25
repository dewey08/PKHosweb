<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
use Illuminate\Contracts\Auth\MustVerifyEmail; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class A_stm_ct_item extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'a_stm_ct_item'; 
    protected $primaryKey = 'a_stm_ct_item_id';
    protected $fillable = [
        'ct_date',  
        'hn',
        'an',
        'cid',
        'ptname',  
        'ct_check',
        'price_check',
        'total_price_check', 
        'opaque_price',
        'total_opaque_price', 
        'total_other_price',
        'before_price',
        'discount',
        'total',
        'sumprice',
        'paid',
        'remain',  
    ];
    // public $timestamps = false; 

  
}
