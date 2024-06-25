<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_aer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql';
    protected $table = 'd_aer';
    protected $primaryKey = 'd_aer_id';
    protected $fillable = [
        'HN', 
        'AN', 
        'DATEOPD',  
        'AUTHAE',  
        'AEDATE',
        'AETIME',
        'AETYPE', 
        'REFER_NO', 
        'REFMAINI', 
        'IREFTYPE', 
        'REFMAINO', 
        'OREFTYPE', 
        'UCAE', 
        'EMTYPE', 
        'SEQ', 
        'AESTATUS', 
        'DALERT', 
        'TALERT'     
    ];

  
}
