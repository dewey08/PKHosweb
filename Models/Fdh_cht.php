<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Fdh_cht extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql';
    protected $table = 'fdh_cht';
    protected $primaryKey = 'fdh_cht_id';
    protected $fillable = [
        'HN','AN','DATE','TOTAL','PAID','PTTYPE','PERSON_ID','SEQ','OPD_MEMO','INVOICE_NO','INVOICE_LT'  
    ];

  
}
