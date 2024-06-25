<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Claim_sixteen_ins extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $connection = 'mysql7';
    protected $table = 'claim_sixteen_ins';
    protected $primaryKey = 'claim_sixteen_ins_id';
    protected $fillable = [
        'HN', 
        'INSCL', 
        'SUBTYPE',  
        'CID',  
        'DATEIN',
        'DATEEXP',
        'HOSPMAIN', 
        'HOSPSUB', 
        'GOVCODE', 
        'GOVNAME', 
        'PERMITNO', 
        'DOCNO', 
        'OWNRPID', 
        'OWNRNAME', 
        'AN', 
        'SEQ', 
        'SUBINSCL', 
        'RELINSCL', 
        'HTYPE',     
    ];

  
}
