<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Fdh_dru extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql';
    protected $table = 'fdh_dru';
    protected $primaryKey = 'fdh_dru_id';
    protected $fillable = [
        'HCODE','HN','AN','CLINIC','PERSON_ID','DATE_SERV','DID','DIDNAME','AMOUNT'    
    ];

  
}
