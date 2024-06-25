<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Repaire_req extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'repaire_req';
    protected $primaryKey = 'repaire_req_id';
    protected $fillable = [
        'repaire_req_no', 
        'repaire_req_year', 
        'repaire_req_speed'     
    ];

  
}
