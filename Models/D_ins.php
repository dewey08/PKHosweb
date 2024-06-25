<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_ins extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $connection = 'mysql';
    protected $table = 'd_ins';
    protected $primaryKey = 'd_ins_id';
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
