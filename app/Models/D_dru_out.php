<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_dru_out extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'd_dru_out';
    protected $primaryKey = 'd_dru_out_id';
    protected $fillable = [
        'HN',
        'PERSON_ID',
        'DID'         
    ];

  
}
