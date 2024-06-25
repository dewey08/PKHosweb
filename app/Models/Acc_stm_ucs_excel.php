<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acc_stm_ucs_excel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acc_stm_ucs_excel';
    protected $primaryKey = 'acc_stm_ucs_excel_id';
    protected $fillable = [
        'rep',
        'repno',
        'tranid',
        'hn',
        'an',  
        'cid', 
        'fullname',  
        'vstdate',
        'dchdate',
        'maininscl',
        'projectcode',
        'debit',
        'debit_prb',
        'adjrw',
        'ps1',
        'ps2',
        'ccuf',
        'adjrw2',
        'pay_money',
        'pay_slip',
        'pay_after',
        'op',
        'ip_pay1',

        'ip_paytrue',
        'hc',
        'hc_drug',
        'ae',
        'ae_drug',
        'inst',
        'dmis_money1',
        'dmis_money2',
        'dmis_drug',
        'palliative_care',
        'dmishd',
        'pp',
        'fs',
        'opbkk',
        'total_approve',

        'va',
        'covid',
        'date_save',
        'STMdoc',
        'active',
        'ao'
    ];


}
