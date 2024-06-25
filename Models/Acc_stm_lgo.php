<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
use Illuminate\Contracts\Auth\MustVerifyEmail; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acc_stm_lgo extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acc_stm_lgo'; 
    // protected $fillable = [
    //     'acc_stm_lgo_id',
    //     'rep',  
    //     'no', 
    //     'tranid',
    //     'hn', 
    //     'an',
    //     'cid',
    //     'fullname', 
    //     'type', 
    //     'vstdate',
    //     'dchdate',
    //     'price1',
    //     'pp_spsch',
    //     'errorcode',
    //     'kongtoon',
    //     'typeservice',
    //     'refer',
    //     'pttype_have',
    //     'pttype_true',
    //     'mian_pttype',
    //     'secon_pttype',
    //     'href',
    //     'HCODE',
    //     'prov1',
    //     'code_dep',
    //     'name_dep',
    //     'proj',
    //     'pa',
    //     'drg',
    //     'rw',
    //     'income',
    //     'pp_gep',
    //     'claim_true',
    //     'claim_false',
    //     'cash_money',
    //     'pay',
    //     'ps',
    //     'ps_percent',
    //     'ccuf',
    //     'AdjRW',
    //     'plb',
    //     'IPLG',
    //     'OPLG',
    //     'PALG',
    //     'INSTLG',
    //     'OTLG',
    //     'PP',
    //     'DRUG',
    //     'IPLG2',
    //     'OPLG2',
    //     'PALG2',
    //     'INSTLG2',
    //     'OTLG2',
    //     'ORS',
    //     'VA',
    //     'STMdoc',
    //     'active'
    // ];
    protected $fillable = [
        'acc_stm_lgo_id',
        'rep_a',  
        'no_b', 
        'tranid_c',
        'hn_d',  
        'STMdoc',
        'active'
    ];
    // public $timestamps = false;   
}
