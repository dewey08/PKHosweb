<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
use Illuminate\Contracts\Auth\MustVerifyEmail; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acc_stm_prb extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acc_stm_prb';
    protected $primaryKey = 'acc_stm_prb_id';
    protected $fillable = [
        'acc_debtor_id',
        'req_no',
        'claim_no',
        'vendor',
        'cid',
        'ptname',
        'no',
        'payprice',
        'paydate',
        'paytype',
        'savedate',
        'money_billno',
        'usersave',
        'active'        
    ];   
    // public $timestamps = false;  
}
