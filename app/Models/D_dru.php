<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_dru extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql';
    protected $table = 'd_dru';
    protected $primaryKey = 'd_dru_id';
    protected $fillable = [
        'HCODE', 
        'HN', 
        'AN',  
        'CLINIC',  
        'PERSON_ID',
        'DATE_SERV',
        'DID', 
        'DIDNAME', 
        'AMOUNT', 
        'DRUGPRIC', 
        'DRUGCOST', 
        'DIDSTD', 
        'UNIT', 
        'UNIT_PACK', 
        'SEQ', 
        'DRUGREMARK', 
        'PA_NO', 
        'TOTCOPAY', 
        'USE_STATUS',     
        'STATUS1',
        'TOTAL',
        'SIGCODE',
        'SIGTEXT'
    ];

  
}
