<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Claim_sixteen_dru extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql7';
    protected $table = 'claim_sixteen_dru';
    protected $primaryKey = 'claim_sixteen_dru_id';
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
        'a1',
        'a2',
    ];

  
}
