<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Claim_sixteen_cha extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql7';
    protected $table = 'claim_sixteen_cha';
    protected $primaryKey = 'claim_sixteen_cha_id';
    protected $fillable = [ 
        'HN', 
        'AN',  
        'DATE',  
        'CHRGITEM',
        'AMOUNT',
        'PERSON_ID', 
        'SEQ'  
    ];

  
}
