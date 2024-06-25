<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Claim_sixteen_cht extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql7';
    protected $table = 'claim_sixteen_cht';
    protected $primaryKey = 'claim_sixteen_cht_id';
    protected $fillable = [ 
        'HN', 
        'AN',  
        'DATE',  
        'TOTAL',
        'PAID',
        'PTTYPE', 
        'PERSON_ID',
        'SEQ' 
    ];

  
}
