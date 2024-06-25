<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Medical_repaire extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'medical_repaire';
    protected $primaryKey = 'medical_repaire_id';
    protected $fillable = [
        'medical_repaire_rep' ,
        'medical_repaire_date' ,
        'medical_repaire_backdate'      
    ];

  
}
