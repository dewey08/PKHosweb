<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Fdh_cha extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'mysql';
    protected $table = 'fdh_cha';
    protected $primaryKey = 'fdh_cha_id';
    protected $fillable = [
        'HN','CLINIC','DATE','CHRGITEM','AMOUNT','PERSON_ID','SEQ'    
    ];

  
}
